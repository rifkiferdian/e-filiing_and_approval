<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        if (isset($this->db)) {
            $this->db->query("SET time_zone = '+07:00'");
        }

        $public_methods = array('verifikasi_doc_approval');
        $current_method = $this->router->fetch_method();

        if (!$this->session->userdata('userid') && !in_array($current_method, $public_methods, true)) {
            if ($this->input->is_ajax_request()) {
                $response = array(
                    'draw' => (int) $this->input->post('draw'),
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => array(),
                    'error' => 'Session expired. Please login again.'
                );

                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($response))
                    ->_display();
                exit;
            }

            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Please Login!</div>');
            redirect('auth');
        }
        $this->load->model("Crud", "crud");
        // $this->load->model("M_nasabah", "nasabah");
        // $this->load->model("M_dashboard", "dashboard");
    }

    public function index()
    {
        $data['title'] = 'SIASEPP KECe | Dashboard dashboard';
        $data['sess_menu'] = 'dashboard';
        $data['apps'] = $this->Crud->get_all('mst_apps')->row_array();
        $data['tahun_surat'] = $this->_get_tahun_surat_dashboard();
        $this->load->view('template/header', $data);
        $this->load->view('dashboard/dashboard', $data);
        $this->load->view('template/footer');
    }

    private function _get_tahun_surat_dashboard()
    {
        $query = $this->db->query("
            SELECT tahun
            FROM (
                SELECT YEAR(tanggal_surat) AS tahun
                FROM tbl_surat_masuk
                WHERE tanggal_surat IS NOT NULL
                UNION
                SELECT YEAR(tanggal_surat) AS tahun
                FROM tbl_surat_keluar
                WHERE tanggal_surat IS NOT NULL
            ) tahun_surat
            WHERE tahun IS NOT NULL AND tahun > 0
            ORDER BY tahun DESC
        ");

        $tahun = array();
        foreach ($query->result_array() as $row) {
            $tahun[] = $row['tahun'];
        }

        return $tahun;
    }

    public function get_doc_approval_dashboard()
    {
        $userid = $this->session->userdata('userid');

        $summary = $this->db->query("
            SELECT
                (SELECT COUNT(*) FROM doc_approval_documents WHERE submitted_by = ?) AS pengajuan_saya,
                (
                    SELECT COUNT(DISTINCT r.id)
                    FROM doc_approval_requests r
                    JOIN doc_approval_steps s ON s.flow_id = r.flow_id AND s.step_order = r.current_step_order
                    JOIN doc_approval_step_approvers a ON a.step_id = s.id
                    LEFT JOIN doc_approval_actions act ON act.request_id = r.id AND act.step_id = s.id AND act.approver_userid = a.approver_userid
                    WHERE a.approver_userid = ?
                    AND r.status IN ('submitted', 'in_review')
                    AND act.id IS NULL
                ) AS perlu_review,
                (SELECT COUNT(*) FROM doc_approval_documents WHERE submitted_by = ? AND status = 'approved') AS disetujui,
                (SELECT COUNT(*) FROM doc_approval_documents WHERE submitted_by = ? AND status IN ('rejected', 'revision_required')) AS perlu_perbaikan
        ", array($userid, $userid, $userid, $userid))->row_array();

        $status_rows = $this->db
            ->select('status, COUNT(*) AS total')
            ->where('submitted_by', $userid)
            ->group_by('status')
            ->get('doc_approval_documents')
            ->result_array();

        $status_map = array(
            'draft' => 0,
            'submitted' => 0,
            'in_review' => 0,
            'approved' => 0,
            'rejected' => 0,
            'revision_required' => 0,
            'cancelled' => 0
        );

        foreach ($status_rows as $row) {
            if (isset($status_map[$row['status']])) {
                $status_map[$row['status']] = (int) $row['total'];
            }
        }

        $months = array();
        $trend = array();
        $start = new DateTime('first day of this month');
        $start->setTime(0, 0, 0);
        $start->modify('-5 months');
        for ($i = 0; $i < 6; $i++) {
            $month = clone $start;
            $month->modify('+'.$i.' months');
            $key = $month->format('Y-m');
            $months[$key] = $this->_nama_bulan_id((int) $month->format('n')).' '.$month->format('Y');
            $trend[$key] = 0;
        }

        $trend_rows = $this->db
            ->select("DATE_FORMAT(submitted_at, '%Y-%m') AS bulan, COUNT(*) AS total", false)
            ->where('submitted_by', $userid)
            ->where('submitted_at >=', $start->format('Y-m-01 00:00:00'))
            ->group_by("DATE_FORMAT(submitted_at, '%Y-%m')", false)
            ->get('doc_approval_documents')
            ->result_array();

        foreach ($trend_rows as $row) {
            if (isset($trend[$row['bulan']])) {
                $trend[$row['bulan']] = (int) $row['total'];
            }
        }

        $latest_rows = $this->db->query("
            SELECT DISTINCT
                r.id AS request_id,
                d.id AS document_id,
                d.title,
                d.document_number,
                d.status AS document_status,
                r.status AS request_status,
                r.submitted_by,
                r.submitted_by_name,
                r.submitted_at,
                f.name AS flow_name,
                CASE
                    WHEN r.submitted_by = ? THEN 'Pemohon'
                    WHEN EXISTS (
                        SELECT 1
                        FROM doc_approval_steps sx
                        JOIN doc_approval_step_approvers ax ON ax.step_id = sx.id
                        LEFT JOIN doc_approval_actions acx ON acx.request_id = r.id AND acx.step_id = sx.id AND acx.approver_userid = ax.approver_userid
                        WHERE sx.flow_id = r.flow_id
                        AND sx.step_order = r.current_step_order
                        AND ax.approver_userid = ?
                        AND r.status IN ('submitted', 'in_review')
                        AND acx.id IS NULL
                    ) THEN 'Perlu Review'
                    ELSE 'Reviewer'
                END AS relasi
            FROM doc_approval_requests r
            JOIN doc_approval_documents d ON d.id = r.document_id
            LEFT JOIN doc_approval_flows f ON f.id = r.flow_id
            WHERE r.submitted_by = ?
            OR EXISTS (
                SELECT 1
                FROM doc_approval_steps s
                JOIN doc_approval_step_approvers a ON a.step_id = s.id
                WHERE s.flow_id = r.flow_id
                AND a.approver_userid = ?
            )
            OR EXISTS (
                SELECT 1
                FROM doc_approval_actions act
                WHERE act.request_id = r.id
                AND act.approver_userid = ?
            )
            ORDER BY r.submitted_at DESC
            LIMIT 5
        ", array($userid, $userid, $userid, $userid, $userid))->result_array();

        $latest = array();
        foreach ($latest_rows as $row) {
            $latest[] = array(
                'request_id' => (int) $row['request_id'],
                'document_id' => (int) $row['document_id'],
                'title' => $row['title'],
                'document_number' => $row['document_number'],
                'status' => $row['document_status'],
                'status_label' => $this->_label_status_doc_approval($row['document_status']),
                'status_class' => $this->_class_status_doc_approval($row['document_status']),
                'flow_name' => $row['flow_name'],
                'submitted_by_name' => $row['submitted_by_name'],
                'submitted_at' => !empty($row['submitted_at']) ? date('d-m-Y H:i', strtotime($row['submitted_at'])) : '-',
                'relasi' => $row['relasi']
            );
        }

        $response = array(
            'summary' => array(
                'pengajuan_saya' => (int) $summary['pengajuan_saya'],
                'perlu_review' => (int) $summary['perlu_review'],
                'disetujui' => (int) $summary['disetujui'],
                'perlu_perbaikan' => (int) $summary['perlu_perbaikan']
            ),
            'status' => array(
                'labels' => array('Draft', 'Diajukan', 'Direview', 'Disetujui', 'Ditolak', 'Revisi', 'Dibatalkan'),
                'values' => array_values($status_map)
            ),
            'trend' => array(
                'labels' => array_values($months),
                'values' => array_values($trend)
            ),
            'latest' => $latest
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    private function _nama_bulan_id($bulan)
    {
        $bulan_id = array(
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Agu',
            9 => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des'
        );

        return isset($bulan_id[$bulan]) ? $bulan_id[$bulan] : '';
    }

    private function _label_status_doc_approval($status)
    {
        $labels = array(
            'draft' => 'Draft',
            'submitted' => 'Diajukan',
            'in_review' => 'Direview',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'revision_required' => 'Perlu Revisi',
            'cancelled' => 'Dibatalkan'
        );

        return isset($labels[$status]) ? $labels[$status] : $status;
    }

    private function _class_status_doc_approval($status)
    {
        $classes = array(
            'draft' => 'secondary',
            'submitted' => 'info',
            'in_review' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            'revision_required' => 'warning',
            'cancelled' => 'secondary'
        );

        return isset($classes[$status]) ? $classes[$status] : 'secondary';
    }

    public function kotak_masuk()
    {
        $data['title'] = 'SIASEPP KECe | Kotak Masuk';
        $data['sess_menu'] = 'kotak_masuk';
        $data['apps'] = $this->Crud->get_all('mst_apps')->row_array();
        $this->load->view('template/header', $data);
        $this->load->view('dashboard/kotak_masuk');
        $this->load->view('template/footer');
    }

    public function indeks()
    {
        $data['title'] = 'SIASEPP KECe | Indeks';
        $data['sess_menu'] = 'indeks';
        $data['apps'] = $this->Crud->get_all('mst_apps')->row_array();
        $this->load->view('template/header', $data);
        $this->load->view('dashboard/indeks');
        $this->load->view('template/footer');
    }

    public function disposisi()
    {
        $data['title'] = 'SIASEPP KECe | Disposisi';
        $data['sess_menu'] = 'disposisi';
        $data['apps'] = $this->Crud->get_all('mst_apps')->row_array();
        $this->load->view('template/header', $data);
        $this->load->view('dashboard/disposisi');
        $this->load->view('template/footer');
    }

    public function monitoring_naskah()
    {
        $data['title'] = 'SIASEPP KECe | Monitoring Naskah';
        $data['sess_menu'] = 'monitoring_naskah';
        $data['apps'] = $this->Crud->get_all('mst_apps')->row_array();
        $this->load->view('template/header', $data);
        $this->load->view('dashboard/monitoring_naskah');
        $this->load->view('template/footer');
    }

    public function ajax_table_monitoring_naskah()
    {
        $masuk = $this->db
            ->select('sm.id, sm.no_surat, sm.asal AS pihak, sm.indeks, sm.sifat, sm.status_surat, sm.nomor_agenda, sm.date_created, COUNT(d.id) AS total_disposisi, GROUP_CONCAT(DISTINCT d.penerima ORDER BY d.penerima SEPARATOR ", ") AS daftar_disposisi')
            ->from('tbl_surat_masuk sm')
            ->join('tbl_disposisi d', 'd.id_surat = sm.id', 'left')
            ->group_by('sm.id')
            ->order_by('sm.date_created', 'DESC')
            ->get()
            ->result();

        $keluar = $this->db
            ->select('id, no_surat, tujuan AS pihak, indeks, sifat, status_approval, date_created')
            ->from('tbl_surat_keluar')
            ->order_by('date_created', 'DESC')
            ->get()
            ->result();

        $data = array();
        $no = 1;

        foreach ($masuk as $row) {
            $data[] = array(
                'no' => $no++,
                'jenis' => 'Masuk',
                'jenis_naskah' => 'masuk',
                'id_naskah' => $row->id,
                'no_surat' => $row->no_surat,
                'pihak' => $row->pihak,
                'indeks' => $row->indeks,
                'sifat' => $row->sifat,
                'nomor_agenda' => $row->nomor_agenda,
                'status' => $row->status_surat,
                'total_disposisi' => (int) $row->total_disposisi,
                'daftar_disposisi' => $row->daftar_disposisi,
                'posisi_sekarang' => '-',
                'approval_detail' => array(),
                'date_created' => date('d-F-Y H:i:s', strtotime($row->date_created))
            );
        }

        foreach ($keluar as $row) {
            $approval_detail = $this->_get_approval_naskah_keluar($row->id);
            $posisi_sekarang = $this->_get_posisi_approval_naskah_keluar($approval_detail, $row->status_approval);

            $data[] = array(
                'no' => $no++,
                'jenis' => 'Keluar',
                'jenis_naskah' => 'keluar',
                'id_naskah' => $row->id,
                'no_surat' => $row->no_surat,
                'pihak' => $row->pihak,
                'indeks' => $row->indeks,
                'sifat' => $row->sifat,
                'nomor_agenda' => '-',
                'status' => $row->status_approval,
                'total_disposisi' => 0,
                'daftar_disposisi' => '-',
                'posisi_sekarang' => $posisi_sekarang,
                'approval_detail' => $approval_detail,
                'date_created' => date('d-F-Y H:i:s', strtotime($row->date_created))
            );
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('data' => $data)));
    }

    private function _get_approval_naskah_keluar($id_surat_keluar)
    {
        return $this->db
            ->select('urutan, approver_userid, approver_name, status, catatan, approved_at')
            ->where('id_surat_keluar', $id_surat_keluar)
            ->order_by('urutan', 'ASC')
            ->get('tbl_approval_naskah_keluar')
            ->result_array();
    }

    private function _get_posisi_approval_naskah_keluar($approval_detail, $status_approval)
    {
        if (empty($approval_detail)) {
            return 'Tidak memakai approval';
        }

        foreach ($approval_detail as $approval) {
            if ($approval['status'] === 'Ditolak') {
                return 'Ditolak oleh '.$approval['approver_name'];
            }
        }

        foreach ($approval_detail as $approval) {
            if ($approval['status'] === 'Menunggu') {
                return 'Menunggu '.$approval['approver_name'];
            }
        }

        return $status_approval === 'Disetujui' ? 'Semua approver menyetujui' : $status_approval;
    }

    public function histori_naskah($jenis_naskah = null, $id_naskah = null)
    {
        $data['title'] = 'SIASEPP KECe | Histori Naskah';
        $data['sess_menu'] = 'histori_naskah';
        $data['apps'] = $this->Crud->get_all('mst_apps')->row_array();
        $data['filter_jenis_naskah'] = in_array($jenis_naskah, array('masuk', 'keluar'), true) ? $jenis_naskah : '';
        $data['filter_id_naskah'] = (int) $id_naskah;
        $data['naskah_info'] = $data['filter_jenis_naskah'] && $data['filter_id_naskah'] > 0
            ? $this->_get_info_naskah_history($data['filter_jenis_naskah'], $data['filter_id_naskah'])
            : null;
        $this->load->view('template/header', $data);
        $this->load->view('dashboard/histori_naskah', $data);
        $this->load->view('template/footer');
    }

    public function ajax_table_histori_naskah()
    {
        $jenis_naskah = $this->input->post('jenis_naskah');
        $id_naskah = (int) $this->input->post('id_naskah');

        $this->db
            ->select('id, jenis_naskah, id_naskah, no_surat, aksi, catatan, pengirim, penerima, userid, nama_user, date_created')
            ->from('tbl_histori_naskah');

        if (in_array($jenis_naskah, array('masuk', 'keluar'), true) && $id_naskah > 0) {
            $this->db->where('jenis_naskah', $jenis_naskah);
            $this->db->where('id_naskah', $id_naskah);
        }

        $result = $this->db
            ->order_by('date_created', 'DESC')
            ->order_by('id', 'DESC')
            ->get()
            ->result();

        $data = array();
        $no = 1;
        foreach ($result as $row) {
            $data[] = array(
                'no' => $no++,
                'jenis_naskah' => ucfirst($row->jenis_naskah),
                'id_naskah' => $row->id_naskah,
                'no_surat' => $row->no_surat,
                'aksi' => $row->aksi,
                'catatan' => $row->catatan,
                'pengirim' => $row->pengirim,
                'penerima' => $row->penerima,
                'user' => trim($row->userid.' - '.$row->nama_user, ' -'),
                'date_created' => date('d-F-Y H:i:s', strtotime($row->date_created))
            );
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('data' => $data)));
    }

    private function _get_info_naskah_history($jenis_naskah, $id_naskah)
    {
        if ($jenis_naskah === 'masuk') {
            return $this->db
                ->select('id, no_surat, asal AS pihak, tanggal_surat, tanggal_surat_diterima, unit_penerima AS unit, indeks, sifat, ringkasan_surat, nama_file, status_surat AS status, nomor_agenda, date_created')
                ->where('id', $id_naskah)
                ->get('tbl_surat_masuk')
                ->row_array();
        }

        return $this->db
            ->select('id, no_surat, tujuan AS pihak, tanggal_surat, NULL AS tanggal_surat_diterima, unit_pengirim AS unit, indeks, sifat, ringkasan_surat, nama_file, status_approval AS status, NULL AS nomor_agenda, date_created', false)
            ->where('id', $id_naskah)
            ->get('tbl_surat_keluar')
            ->row_array();
    }

    public function get_histori_naskah()
    {
        $jenis = $this->input->post('jenis_naskah');
        $id = $this->input->post('id_naskah');

        $result = $this->db
            ->where('jenis_naskah', $jenis)
            ->where('id_naskah', $id)
            ->order_by('date_created', 'ASC')
            ->order_by('id', 'ASC')
            ->get('tbl_histori_naskah')
            ->result();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function template_approval()
    {
        $data['title'] = 'SIASEPP KECe | Template Approval';
        $data['sess_menu'] = 'template_approval';
        $data['apps'] = $this->Crud->get_all('mst_apps')->row_array();
        $this->load->view('template/header', $data);
        $this->load->view('dashboard/template_approval');
        $this->load->view('template/footer');
    }

    public function ajax_table_template_approval()
    {
        $templates = $this->db
            ->select('ta.id, ta.nama_template, ta.deskripsi, ta.is_active, ta.date_created, COUNT(tad.id) AS total_approver')
            ->from('mst_template_approval ta')
            ->join('mst_template_approval_detail tad', 'tad.template_id = ta.id', 'left')
            ->group_by('ta.id')
            ->order_by('ta.id', 'DESC')
            ->get()
            ->result();

        $data = array();
        $no = 1;
        foreach ($templates as $template) {
            $approvers = $this->db
                ->select('urutan, approver_userid, approver_name')
                ->where('template_id', $template->id)
                ->order_by('urutan', 'ASC')
                ->get('mst_template_approval_detail')
                ->result_array();

            $data[] = array(
                'no' => $no++,
                'id' => $template->id,
                'nama_template' => $template->nama_template,
                'deskripsi' => $template->deskripsi,
                'is_active' => $template->is_active,
                'total_approver' => (int) $template->total_approver,
                'approvers' => $approvers,
                'date_created' => date('d-F-Y H:i:s', strtotime($template->date_created))
            );
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('data' => $data)));
    }

    public function get_template_approval()
    {
        $templates = $this->db
            ->where('is_active', 1)
            ->order_by('nama_template', 'ASC')
            ->get('mst_template_approval')
            ->result_array();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($templates));
    }

    public function get_template_approval_detail()
    {
        $template_id = $this->input->post('template_id');
        $details = $this->db
            ->where('template_id', $template_id)
            ->order_by('urutan', 'ASC')
            ->get('mst_template_approval_detail')
            ->result_array();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($details));
    }

    public function simpan_template_approval()
    {
        $nama_template = trim((string) $this->input->post('nama_template'));
        $deskripsi = trim((string) $this->input->post('deskripsi'));
        $approver_userid = $this->input->post('approver_userid');
        $approver_userid = is_array($approver_userid) ? array_values(array_filter($approver_userid)) : array();

        if ($nama_template === '' || empty($approver_userid)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('status' => 'error', 'message' => 'Template dan approver wajib diisi.')));
            return;
        }

        $this->db->trans_start();
        $this->db->insert('mst_template_approval', array(
            'nama_template' => $nama_template,
            'deskripsi' => $deskripsi,
            'is_active' => 1
        ));
        $template_id = $this->db->insert_id();

        foreach ($approver_userid as $index => $userid) {
            $user = $this->db->get_where('user', array('userid' => $userid))->row_array();
            if ($user) {
                $this->db->insert('mst_template_approval_detail', array(
                    'template_id' => $template_id,
                    'urutan' => $index + 1,
                    'approver_userid' => $user['userid'],
                    'approver_name' => $user['name'],
                    'role_label' => 'Level '.$user['role_id']
                ));
            }
        }
        $this->db->trans_complete();

        $response = $this->db->trans_status()
            ? array('status' => 'success', 'message' => 'Template approval berhasil disimpan.')
            : array('status' => 'error', 'message' => 'Template approval gagal disimpan.');

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function update_template_approval()
    {
        $template_id = (int) $this->input->post('template_id');
        $nama_template = trim((string) $this->input->post('nama_template'));
        $deskripsi = trim((string) $this->input->post('deskripsi'));
        $approver_userid = $this->input->post('approver_userid');
        $approver_userid = is_array($approver_userid) ? array_values(array_filter($approver_userid)) : array();

        if ($template_id <= 0 || $nama_template === '' || empty($approver_userid)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('status' => 'error', 'message' => 'Template dan approver wajib diisi.')));
            return;
        }

        $template = $this->db->get_where('mst_template_approval', array('id' => $template_id))->row_array();
        if (!$template) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('status' => 'error', 'message' => 'Template approval tidak ditemukan.')));
            return;
        }

        $this->db->trans_start();
        $this->db->update('mst_template_approval', array(
            'nama_template' => $nama_template,
            'deskripsi' => $deskripsi
        ), array('id' => $template_id));

        $this->db->delete('mst_template_approval_detail', array('template_id' => $template_id));
        foreach ($approver_userid as $index => $userid) {
            $user = $this->db->get_where('user', array('userid' => $userid))->row_array();
            if ($user) {
                $this->db->insert('mst_template_approval_detail', array(
                    'template_id' => $template_id,
                    'urutan' => $index + 1,
                    'approver_userid' => $user['userid'],
                    'approver_name' => $user['name'],
                    'role_label' => 'Level '.$user['role_id']
                ));
            }
        }
        $this->db->trans_complete();

        $response = $this->db->trans_status()
            ? array('status' => 'success', 'message' => 'Template approval berhasil diupdate.')
            : array('status' => 'error', 'message' => 'Template approval gagal diupdate.');

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function delete_template_approval()
    {
        $id = $this->input->post('id');

        $this->db->trans_start();
        $this->db->delete('mst_template_approval_detail', array('template_id' => $id));
        $this->db->delete('mst_template_approval', array('id' => $id));
        $this->db->trans_complete();

        $response = $this->db->trans_status()
            ? array('status' => 'success', 'message' => 'Template approval berhasil dihapus.')
            : array('status' => 'error', 'message' => 'Template approval gagal dihapus.');

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    private function _buat_approval_naskah_keluar($id_surat_keluar, $template_id)
    {
        if (empty($template_id)) {
            return;
        }

        $details = $this->db
            ->where('template_id', $template_id)
            ->order_by('urutan', 'ASC')
            ->get('mst_template_approval_detail')
            ->result_array();

        foreach ($details as $detail) {
            $this->db->insert('tbl_approval_naskah_keluar', array(
                'id_surat_keluar' => $id_surat_keluar,
                'template_id' => $template_id,
                'urutan' => $detail['urutan'],
                'approver_userid' => $detail['approver_userid'],
                'approver_name' => $detail['approver_name'],
                'status' => 'Menunggu'
            ));
        }
    }

    private function _log_histori_naskah($jenis_naskah, $id_naskah, $no_surat, $aksi, $catatan = '', $pengirim = null, $penerima = null)
    {
        $this->db->insert('tbl_histori_naskah', array(
            'jenis_naskah' => $jenis_naskah,
            'id_naskah' => $id_naskah,
            'no_surat' => $no_surat,
            'aksi' => $aksi,
            'catatan' => $catatan,
            'pengirim' => $pengirim,
            'penerima' => $penerima,
            'userid' => $this->session->userdata('userid'),
            'nama_user' => $this->session->userdata('name'),
            'role_id' => $this->session->userdata('role_id')
        ));
    }

    public function ajax_table_indeks()
    {

        $table = 'mst_indeks'; //nama tabel dari database
        $column_order = array('id', 'nama', 'kode', 'deskripsi', 'date_created'); //field yang ada di table user
        $column_search = array('id', 'nama', 'kode', 'deskripsi', 'date_created'); //field yang diizin untuk pencarian 
        $select = 'id, nama, kode, deskripsi, date_created';
        $order = array('id' => 'asc'); // default order 
        $list = $this->crud->get_datatables($table, $select, $column_order, $column_search, $order);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row['data']['no'] = $no;
            $row['data']['id'] = $key->id;
            $row['data']['nama'] = $key->nama;
            $row['data']['kode'] = $key->kode;
            $row['data']['deskripsi'] = $key->deskripsi;
            $row['data']['date_created'] = date('d-F-Y H:i:s', strtotime($key->date_created));

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->crud->count_all($table),
            "recordsFiltered" => $this->crud->count_filtered($table, $select, $column_order, $column_search, $order),
            "data" => $data,
            "query" => $this->db->last_query()
        );
        //output to json format
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($output));
    }

    function addindeks()
    {

        $data = array(
            'kode' => $this->input->post('kode'),
            'nama' => $this->input->post('nama'),
            'deskripsi' => $this->input->post('deskripsi'),
        );

        $this->crud->insert('mst_indeks', $data);

        if ($this->db->affected_rows() == true) {
            $insert_log = $this->db->insert('tbl_log', ['userid' => $this->session->userdata('userid'), 'activity' => 'Register new indeks ' . $this->input->post('nama')]);
            $response = ['status' => '200', 'message' => 'Success Register Indeks!', 'indeks' => $data["kode"]];
        } else
            $response = ['status' => '400', 'message' => 'Error Register Indeks!'];
        echo json_encode($response);
    }

    public function delete_data()
    {
        $table = $this->input->post('table');
        $name = $this->input->post('name');
        if ($this->crud->delete($table, ['id' => $this->input->post('id')])) {
            $insert_log = $this->db->insert('tbl_log', ['userid' => $this->session->userdata('userid'), 'activity' => 'Delete data ' . $table . ' - ' . $name]);
            $response = ['status' => 'success', 'message' => 'Success Delete Data!'];
        } else
            $response = ['status' => 'failed', 'message' => 'Error Delete Data!'];

        echo json_encode($response);
    }

    public function ajax_table_unit()
    {

        $table = 'mst_unit_kerja'; //nama tabel dari database
        $column_order = array('id', 'nama', 'kode', 'deskripsi', 'date_created'); //field yang ada di table user
        $column_search = array('id', 'nama', 'kode', 'deskripsi', 'date_created'); //field yang diizin untuk pencarian 
        $select = 'id, nama, kode, deskripsi, date_created';
        $order = array('id' => 'asc'); // default order 
        $list = $this->crud->get_datatables($table, $select, $column_order, $column_search, $order);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row['data']['no'] = $no;
            $row['data']['id'] = $key->id;
            $row['data']['nama'] = $key->nama;
            $row['data']['kode'] = $key->kode;
            $row['data']['deskripsi'] = $key->deskripsi;
            $row['data']['date_created'] = date('d-F-Y H:i:s', strtotime($key->date_created));

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->crud->count_all($table),
            "recordsFiltered" => $this->crud->count_filtered($table, $select, $column_order, $column_search, $order),
            "data" => $data,
            "query" => $this->db->last_query()
        );
        //output to json format
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($output));
    }

    public function unit()
    {
        $data['title'] = 'SIASEPP KECe | Unit Kerja';
        $data['sess_menu'] = 'unit';
        $data['apps'] = $this->Crud->get_all('mst_apps')->row_array();
        $this->load->view('template/header', $data);
        $this->load->view('dashboard/unit');
        $this->load->view('template/footer');
    }

    public function user_role()
    {
        $data['title'] = 'SIASEPP KECe | User Role';
        $data['sess_menu'] = 'user_role';
        $data['apps'] = $this->Crud->get_all('mst_apps')->row_array();
        $this->load->view('template/header', $data);
        $this->load->view('dashboard/user_role');
        $this->load->view('template/footer');
    }

    public function ajax_table_user_role()
    {
        $table = 'user_role';
        $column_order = array('id', 'role');
        $column_search = array('id', 'role');
        $select = 'id, role';
        $order = array('id' => 'asc');
        $list = $this->crud->get_datatables($table, $select, $column_order, $column_search, $order);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row['data']['no'] = $no;
            $row['data']['id'] = $key->id;
            $row['data']['role'] = $key->role;
            $row['data']['jumlah_user'] = $this->Crud->get_where('user', ['role_id' => $key->id])->num_rows();

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->crud->count_all($table),
            "recordsFiltered" => $this->crud->count_filtered($table, $select, $column_order, $column_search, $order),
            "data" => $data,
            "query" => $this->db->last_query()
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($output));
    }

    public function adduserrole()
    {
        $id = $this->input->post('id');
        $role = trim((string) $this->input->post('role'));

        if ($role == '') {
            $response = ['status' => '400', 'message' => 'Nama role wajib diisi!'];
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
            return;
        }

        $this->db->from('user_role');
        $this->db->where('role', $role);
        if ($id != '') {
            $this->db->where('id <>', $id);
        }
        $cek = $this->db->count_all_results();
        if ($cek > 0) {
            $response = ['status' => '400', 'message' => 'Nama role sudah terdaftar!'];
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
            return;
        }

        if ($id != '') {
            $this->crud->update('user_role', ['role' => $role], ['id' => $id]);
            $success = true;
            $activity = 'Update user role ' . $role;
            $message = 'Success Update User Role!';
        } else {
            $this->crud->insert('user_role', ['role' => $role]);
            $success = ($this->db->affected_rows() == true);
            $activity = 'Register new user role ' . $role;
            $message = 'Success Register User Role!';
        }

        if ($success) {
            $this->db->insert('tbl_log', ['userid' => $this->session->userdata('userid'), 'activity' => $activity]);
            $response = ['status' => '200', 'message' => $message];
        } else {
            $response = ['status' => '400', 'message' => 'Error Register User Role!'];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function delete_user_role()
    {
        $id = $this->input->post('id');
        $role = $this->input->post('role');
        $jumlah_user = $this->Crud->get_where('user', ['role_id' => $id])->num_rows();

        if ($jumlah_user > 0) {
            $response = ['status' => 'failed', 'message' => 'Role masih dipakai oleh ' . $jumlah_user . ' user. Pindahkan user ke role lain dulu.'];
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
            return;
        }

        if ($this->crud->delete('user_role', ['id' => $id])) {
            $this->db->insert('tbl_log', ['userid' => $this->session->userdata('userid'), 'activity' => 'Delete user role ' . $role]);
            $response = ['status' => 'success', 'message' => 'Success Delete User Role!'];
        } else {
            $response = ['status' => 'failed', 'message' => 'Error Delete User Role!'];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function change()
    {
        $data['title'] = 'SIASEPP KECe | Ubah Password';
        $data['sess_menu'] = 'change';
        $data['apps'] = $this->Crud->get_all('mst_apps')->row_array();
        $this->load->view('template/header', $data);
        $this->load->view('dashboard/change');
        $this->load->view('template/footer');
    }

    function addunit()
    {

        $data = array(
            'kode' => $this->input->post('kode'),
            'nama' => $this->input->post('nama'),
            'deskripsi' => $this->input->post('deskripsi'),
        );

        $this->crud->insert('mst_unit_kerja', $data);

        if ($this->db->affected_rows() == true) {
            $insert_log = $this->db->insert('tbl_log', ['userid' => $this->session->userdata('userid'), 'activity' => 'Register new unit kerja ' . $this->input->post('nama')]);
            $response = ['status' => '200', 'message' => 'Success Register unit kerja!', 'unit kerja' => $data["kode"]];
        } else
            $response = ['status' => '400', 'message' => 'Error Register unit kerja!'];
        echo json_encode($response);
    }

    public function user()
    {
        $data['title'] = 'SIASEPP KECe | User';
        $data['sess_menu'] = 'user';
        $data['apps'] = $this->Crud->get_all('mst_apps')->row_array();
        $this->load->view('template/header', $data);
        $this->load->view('dashboard/user');
        $this->load->view('template/footer');
    }

    public function ajax_table_user()
    {
        $get_role_id = $this->crud->get_all("user_role")->result_array();

        $table = 'user'; //nama tabel dari database
        $column_order = array('id', 'name', 'userid', 'role_id', 'nomor_induk', 'date_created'); //field yang ada di table user
        $column_search = array('id', 'name', 'userid', 'role_id', 'nomor_induk', 'date_created'); //field yang diizin untuk pencarian 
        $select = 'id, name, userid, role_id, nomor_induk, date_created';
        $order = array('id' => 'asc'); // default order 
        $list = $this->crud->get_datatables($table, $select, $column_order, $column_search, $order);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row['data']['no'] = $no;
            $row['data']['id'] = $key->id;
            $row['data']['userid'] = $key->userid;
            foreach ($get_role_id as $role) {
                if ($role['id'] == $key->role_id)
                    $row['data']['role_id'] = $role['role'];
            }
            $row['data']['name'] = $key->name;
            $row['data']['nomor_induk'] = $key->nomor_induk;
            $row['data']['date_created'] = date('d-F-Y H:i:s', strtotime($key->date_created));

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->crud->count_all($table),
            "recordsFiltered" => $this->crud->count_filtered($table, $select, $column_order, $column_search, $order),
            "data" => $data,
            "query" => $this->db->last_query()
        );
        //output to json format
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($output));
    }

    function adduser()
    {
        //ambil data dari tabel
        $a = $this->crud->get_all_limit('user')->row_array();

        $b = explode('-', $a['userid']);
        $c = $b[1] + 1;
        $d = uniqid();

        $data = array(
            'name' => $this->input->post('nama'),
            'userid' => 'USR-' . $c,
            'password' => password_hash($d, PASSWORD_DEFAULT),
            'nomor_induk' => $this->input->post('nomor_induk'),
            'role_id' => $this->input->post('level'),
            'is_active' => '1',
        );

        $this->crud->insert('user', $data);

        if ($this->db->affected_rows() == true) {
            $insert_log = $this->db->insert('tbl_log', ['userid' => $this->session->userdata('userid'), 'activity' => 'Register new user ' . $this->input->post('nama')]);
            $response = ['status' => '200', 'message' => 'Success Register User!', 'user' => $data["userid"], 'password' => $d];
        } else
            $response = ['status' => '400', 'message' => 'Error Register User!'];
        echo json_encode($response);
    }

    public function surat_masuk()
    {
        $data['title'] = 'SIASEPP KECe | Surat Masuk';
        $data['sess_menu'] = 'surat_masuk';
        $data['apps'] = $this->Crud->get_all('mst_apps')->row_array();
        $this->load->view('template/header', $data);
        $this->load->view('dashboard/surat_masuk');
        $this->load->view('template/footer');
    }

    public function agenda_surat()
    {
        $data['title'] = 'SIASEPP KECe | Agenda Surat';
        $data['sess_menu'] = 'agenda_surat';
        $data['apps'] = $this->Crud->get_all('mst_apps')->row_array();
        $this->load->view('template/header', $data);
        $this->load->view('dashboard/agenda_surat');
        $this->load->view('template/footer');
    }

    public function ajax_table_surat_masuk()
    {

        $table = 'tbl_surat_masuk'; //nama tabel dari database
        $column_order = array('id', 'asal', 'no_surat', 'tanggal_surat', 'unit_penerima', 'indeks', 'sifat', 'status_surat', 'date_created'); //field yang ada di table user
        $column_search = array('id', 'asal', 'no_surat', 'tanggal_surat', 'unit_penerima', 'indeks', 'sifat', 'status_surat', 'date_created'); //field yang diizin untuk pencarian 
        $select = 'id, asal, no_surat, tanggal_surat, unit_penerima, indeks, sifat, status_surat,date_created';
        $order = array('id' => 'asc'); // default order 
        $list = $this->crud->get_datatables($table, $select, $column_order, $column_search, $order);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row['data']['no'] = $no;
            $row['data']['id'] = $key->id;
            $row['data']['asal'] = $key->asal;
            $row['data']['no_surat'] = $key->no_surat;
            $row['data']['tanggal_surat'] = date('d-F-Y', strtotime($key->tanggal_surat));
            $row['data']['unit_penerima'] = $key->unit_penerima;
            $row['data']['indeks'] = $key->indeks;
            $row['data']['sifat'] = $key->sifat;
            $row['data']['status_surat'] = $key->status_surat;
            $row['data']['date_created'] = date('d-F-Y H:i:s', strtotime($key->date_created));

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->crud->count_all($table),
            "recordsFiltered" => $this->crud->count_filtered($table, $select, $column_order, $column_search, $order),
            "data" => $data,
            "query" => $this->db->last_query()
        );
        //output to json format
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($output));
    }

    public function ajax_table_agenda_surat()
    {
        $draw = (int) $this->input->post('draw');
        $start = (int) $this->input->post('start');
        $length = (int) $this->input->post('length');
        $search = isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '';

        $this->_query_agenda_naskah($search);
        $recordsFiltered = $this->db->get()->num_rows();

        $this->_query_agenda_naskah($search);
        $this->db->order_by('tanggal_terakhir', 'DESC');
        if ($length != -1) {
            $this->db->limit($length, $start);
        }
        $list = $this->db->get()->result();

        $data = array();
        $no = $start;
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row['data']['no'] = $no;
            $row['data']['id_surat'] = $key->id_surat;
            $row['data']['no_surat'] = $key->no_surat;
            $row['data']['pengirim'] = $key->pengirim;
            $row['data']['penerima'] = $key->penerima;
            $row['data']['nomor_agenda'] = $key->nomor_agenda;
            $row['data']['date_created'] = date('d-F-Y H:i:s', strtotime($key->tanggal_terakhir));

            $data[] = $row;
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $this->_count_agenda_naskah(),
            "recordsFiltered" => $recordsFiltered,
            "data" => $data,
            "query" => $this->db->last_query()
        );
        //output to json format
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($output));
    }

    private function _query_agenda_naskah($search = '')
    {
        $this->db
            ->select('d.id_surat, sm.no_surat, sm.asal AS pengirim, GROUP_CONCAT(DISTINCT d.penerima ORDER BY d.penerima SEPARATOR ", ") AS penerima, sm.nomor_agenda, MAX(d.date_created) AS tanggal_terakhir')
            ->from('tbl_disposisi d')
            ->join('tbl_surat_masuk sm', 'sm.id = d.id_surat', 'left')
            ->group_by('d.id_surat, sm.no_surat, sm.asal, sm.nomor_agenda');

        if ($search !== '') {
            $this->db->group_start();
            $this->db->like('sm.no_surat', $search);
            $this->db->or_like('sm.asal', $search);
            $this->db->or_like('d.penerima', $search);
            $this->db->or_like('sm.nomor_agenda', $search);
            $this->db->group_end();
        }
    }

    private function _count_agenda_naskah()
    {
        return (int) $this->db
            ->select('COUNT(DISTINCT id_surat) AS total')
            ->get('tbl_disposisi')
            ->row()
            ->total;
    }

    public function ajax_table_kotak_masuk()
    {

        $table = 'tbl_pesan'; //nama tabel dari database
        $column_order = array('id', 'pengirim', 'perihal', 'isi_pesan', 'nama_file', 'date_created'); //field yang ada di table user
        $column_search = array('id', 'pengirim', 'perihal', 'isi_pesan', 'nama_file', 'date_created'); //field yang diizin untuk pencarian 
        $select = 'id, pengirim, perihal, isi_pesan, nama_file, date_created';
        $order = array('id' => 'asc'); // default order 
        $list = $this->crud->get_datatables($table, $select, $column_order, $column_search, $order);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row['data']['no'] = $no;
            $row['data']['id'] = $key->id;
            $row['data']['pengirim'] = $key->pengirim;
            $row['data']['perihal'] = $key->perihal;
            $row['data']['isi_pesan'] = $key->isi_pesan;
            $row['data']['nama_file'] = $key->nama_file;
            $row['data']['date_created'] = date('d-F-Y H:i:s', strtotime($key->date_created));

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->crud->count_all($table),
            "recordsFiltered" => $this->crud->count_filtered($table, $select, $column_order, $column_search, $order),
            "data" => $data,
            "query" => $this->db->last_query()
        );
        //output to json format
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($output));
    }

    public function getunit()
    {
        $result = $this->Crud->get_all('mst_unit_kerja')->result_array();

        echo json_encode($result);
    }

    public function getuserrole()
    {
        $result = $this->db->order_by('id', 'ASC')->get('user_role')->result_array();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function getindeks()
    {
        $result = $this->Crud->get_all('mst_indeks')->result_array();

        echo json_encode($result);
    }

    public function getuser()
    {
        $result = $this->Crud->get_where('user', ['userid <>' => $this->session->userdata('userid')])->result_array();

        echo json_encode($result);
    }

    public function insert_surat_masuk()
    {

        $table = $this->input->post("table");

        $config['upload_path']          = "assets/surat_masuk/";
        $config['allowed_types']        = 'jpg|png|jpeg|JPG|PNG|JPEG|pdf|PDF';
        $config['max_size']             = 100024;
        $config['max_width']            = 5000;
        $config['max_height']           = 5000;

        $this->load->library('upload', $config);
        $data = $this->input->post();
        // var_dump($data);
        // die;
        unset($data['table']);
        // $data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        $data['status_surat'] = 'Belum diteruskan';

        if (count($_FILES) > 0) {
            if (!$this->upload->do_upload('file')) {
                $response = array('status' => 'failed', 'message' => $this->upload->display_errors());
                echo json_encode($response);
                die;
            }
            $data_upload = $this->upload->data();
            $data['nama_file'] = $data_upload['file_name'];
        }

        $insert_data = $this->crud->insert($table, $data);

        if ($this->db->affected_rows() == true) {
            $this->_log_histori_naskah(
                'masuk',
                $this->db->insert_id(),
                $data['no_surat'],
                'Input Naskah Masuk',
                'Naskah masuk dicatat oleh '.$this->session->userdata('name'),
                $data['asal'],
                $data['unit_penerima']
            );
            $response = ['status' => 'success', 'message' => 'Berhasil Tambah Data!'];
        } else
            $response = ['status' => 'error', 'message' => 'Gagal Tambah Data!'];

        echo json_encode($response);
    }

    public function insert_surat_keluar()
    {

        $table = $this->input->post("table");

        $config['upload_path']          = "assets/surat_keluar/";
        $config['allowed_types']        = 'jpg|png|jpeg|JPG|PNG|JPEG|pdf|PDF';
        $config['max_size']             = 100024;
        $config['max_width']            = 5000;
        $config['max_height']           = 5000;

        $this->load->library('upload', $config);
        $data = $this->input->post();
        // var_dump($data);
        // die;
        unset($data['table']);
        // $data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        // $data['status_surat'] = 'Belum diteruskan';
        $data['status_approval'] = empty($data['template_approval_id']) ? 'Draft' : 'Menunggu Approval';

        if (count($_FILES) > 0) {
            if (!$this->upload->do_upload('file')) {
                $response = array('status' => 'failed', 'message' => $this->upload->display_errors());
                echo json_encode($response);
                die;
            }
            $data_upload = $this->upload->data();
            $data['nama_file'] = $data_upload['file_name'];
        }

        $insert_data = $this->crud->insert($table, $data);
        $id_surat_keluar = $this->db->insert_id();

        if ($this->db->affected_rows() == true) {
            $this->_buat_approval_naskah_keluar($id_surat_keluar, isset($data['template_approval_id']) ? $data['template_approval_id'] : null);
            $this->_log_histori_naskah(
                'keluar',
                $id_surat_keluar,
                $data['no_surat'],
                'Input Naskah Keluar',
                'Naskah keluar dicatat oleh '.$this->session->userdata('name'),
                $data['unit_pengirim'],
                $data['tujuan']
            );
            $response = ['status' => 'success', 'message' => 'Berhasil Tambah Data!'];
        } else
            $response = ['status' => 'error', 'message' => 'Gagal Tambah Data!'];

        echo json_encode($response);
    }

    public function download_surat_masuk()
    {
        force_download('assets/surat_masuk/' . $this->input->get('lokasi'), NULL);
    }

    public function download_surat_keluar()
    {
        force_download('assets/surat_keluar/' . $this->input->get('lokasi'), NULL);
    }

    public function update_data_surat()
    {
        $table = $this->input->post("table");
        $id = $this->input->post("id");

        $config['upload_path']          = "assets/surat_masuk/";
        $config['allowed_types']        = 'jpg|png|jpeg|JPG|PNG|JPEG|pdf|PDF';
        $config['max_size']             = 100024;
        $config['max_width']            = 5000;
        $config['max_height']           = 5000;

        $this->load->library('upload', $config);
        $data = $this->input->post();
        unset($data['table']);
        // unset($data['password']);
        $data['status_surat'] = 'Belum diteruskan';

        if (count($_FILES) > 0) {
            if (!$this->upload->do_upload('file')) {
                $response = array('status' => 'failed', 'message' => $this->upload->display_errors());
                echo json_encode($response);
                die;
            }
            $data_upload = $this->upload->data();
            $data['nama_file'] = $data_upload['file_name'];
        }

        $update = $this->crud->update($table, $data, ['id' => $id]);


        if ($update > 0) {
            $response = ['status' => 'success', 'message' => 'Berhasil Edit Data!'];
        } else
            $response = ['status' => 'error', 'message' => 'Gagal Edit Data!'];

        echo json_encode($response);
    }

    public function update_agenda()
    {
        $table = $this->input->post("table");
        $table2 = $this->input->post("table2");
        $id_surat = $this->input->post("id_surat");
        $nomor_agenda = trim((string) $this->input->post("nomor_agenda"));

        if ($nomor_agenda === '') {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Nomor agenda wajib diisi!']));
            return;
        }

        $where = array(
            'id_surat' => $id_surat
        );
        $where2 = array(
            'id' => $id_surat
        );


        $data = $this->input->post();
        unset($data['table']);
        unset($data['table2']);
        unset($data['id_surat']);
        $data['nomor_agenda'] = $nomor_agenda;

        $update = $this->crud->update($table, $data, $where);
        $update2 = $this->crud->update($table2, $data, $where2);


        if ($update > 0 || $update2 > 0) {
            $surat = $this->db->get_where('tbl_surat_masuk', array('id' => $id_surat))->row_array();
            if ($surat) {
                $this->_log_histori_naskah(
                    'masuk',
                    $id_surat,
                    $surat['no_surat'],
                    'Nomor Agenda',
                    'Nomor agenda ditetapkan: '.$nomor_agenda,
                    $surat['asal'],
                    $surat['unit_penerima']
                );
            }
            $response = ['status' => 'success', 'message' => 'Berhasil Edit Data!'];
        } else
            $response = ['status' => 'error', 'message' => 'Gagal Edit Data!'];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function update_surat_keluar()
    {
        $table = $this->input->post("table");
        $id = $this->input->post("id");
        $old = $this->db->get_where($table, array('id' => $id))->row_array();

        $config['upload_path']          = "assets/surat_keluar/";
        $config['allowed_types']        = 'jpg|png|jpeg|JPG|PNG|JPEG|pdf|PDF';
        $config['max_size']             = 100024;
        $config['max_width']            = 5000;
        $config['max_height']           = 5000;

        $this->load->library('upload', $config);
        $data = $this->input->post();
        unset($data['table']);
        unset($data['id']);
        // unset($data['password']);
        // $data['status_surat'] = 'Belum diteruskan';
        if (array_key_exists('template_approval_id', $data)) {
            $data['status_approval'] = empty($data['template_approval_id']) ? 'Draft' : 'Menunggu Approval';
        }

        if (count($_FILES) > 0) {
            if (!$this->upload->do_upload('file')) {
                $response = array('status' => 'failed', 'message' => $this->upload->display_errors());
                echo json_encode($response);
                die;
            }
            $data_upload = $this->upload->data();
            $data['nama_file'] = $data_upload['file_name'];
        }

        $update = $this->crud->update($table, $data, ['id' => $id]);


        if ($update > 0) {
            if (isset($data['template_approval_id']) && (!$old || $old['template_approval_id'] != $data['template_approval_id'])) {
                $this->db->delete('tbl_approval_naskah_keluar', array('id_surat_keluar' => $id));
                $this->_buat_approval_naskah_keluar($id, $data['template_approval_id']);
            }
            $response = ['status' => 'success', 'message' => 'Berhasil Edit Data!'];
        } else
            $response = ['status' => 'error', 'message' => 'Gagal Edit Data!'];

        echo json_encode($response);
    }

    public function teruskan_surat()
    {
        $id_surat = $this->input->post("id_surat");
        $data_surat = $this->db->get_where("tbl_surat_masuk", ["id" => $id_surat])->row_array();

        $data = $this->input->post();
        $data['pesan'] = $data['pesan_teruskan'];
        unset($data['pesan_teruskan']);

        $this->_teruskan_pesan_majemuk($data, $data_surat);


        if ($this->db->affected_rows() == true) {
            $this->_log_histori_naskah(
                'masuk',
                $id_surat,
                $data_surat['no_surat'],
                'Disposisi',
                isset($data['pesan']) ? $data['pesan'] : '',
                $this->session->userdata('name'),
                isset($data['penerima']) ? $data['penerima'] : null
            );
            $response = ['status' => 'success', 'message' => 'Berhasil Meneruskan Pesan!'];
        } else
            $response = ['status' => 'error', 'message' => 'Gagal Meneruskan Pesan!'];

        echo json_encode($response);
    }

    private function _teruskan_pesan_majemuk($data, $data_surat, $index = 0)
    {
        $data_disposisi = $data;
        unset($data_disposisi['pesan']);

        $data_pesan = $data;
        $data_pesan['id_surat_masuk'] = $data_pesan['id_surat'];
        $data_pesan['perihal'] = $data_surat['indeks'];
        $data_pesan['nama_file'] = $data_surat['nama_file'];
        unset($data_pesan['id_surat']);
        unset($data_pesan['no_surat']);
        if ($index < 1)
            $update = $this->crud->update('tbl_surat_masuk', ['status_surat' => 'Didisposisikan'], ['id' => $data['id_surat']]);

        if (!isset($data['penerima_value'])) {
            if ($this->_sudah_didisposisikan($data['id_surat'], $data_disposisi['penerima'])) {
                return;
            }

            $this->crud->insert("tbl_disposisi", $data_disposisi);
            $this->crud->insert("tbl_pesan", $data_pesan);
        } else {
            $data['penerima_value'] = array_values(array_unique($data['penerima_value']));

            unset($data_disposisi['penerima_value']);
            $data_disposisi['penerima'] = $data['penerima_value'][$index];

            unset($data_pesan['penerima_value']);
            $data_pesan['penerima'] = $data['penerima_value'][$index];

            if (!$this->_sudah_didisposisikan($data['id_surat'], $data_disposisi['penerima'])) {
                $this->crud->insert("tbl_disposisi", $data_disposisi);
                $this->crud->insert("tbl_pesan", $data_pesan);
            }

            if ($index < count($data['penerima_value']) - 1)
                $this->_teruskan_pesan_majemuk($data, $data_surat, $index + 1);
        }
    }

    public function teruskan_pesan()
    {
        $id_surat = $this->input->post("id_surat");
        $data_surat = $this->db->get_where("tbl_surat_masuk", ["id" => $id_surat])->row_array();

        $data = $this->input->post();
        $penerima = isset($data['penerima']) ? $data['penerima'] : '';

        if ($this->_sudah_didisposisikan($id_surat, $penerima)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'error',
                    'message' => 'Naskah ini sudah pernah diteruskan ke '.$penerima.'.'
                ]));
            return;
        }

        $data_disposisi = $data;
        unset($data_disposisi['pesan']);
        unset($data_disposisi['table']);
        $data_disposisi['no_surat'] = $data_surat['no_surat'];

        $data_pesan = $data;
        $data_pesan['id_surat_masuk'] = $data_pesan['id_surat'];
        $data_pesan['perihal'] = $data_surat['indeks'];
        $data_pesan['nama_file'] = $data_surat['nama_file'];
        unset($data_pesan['id_surat']);
        unset($data_pesan['no_surat']);


        // echo "<pre>";
        // var_dump($data);
        // echo "</pre>";
        // die;

        $update = $this->crud->update('tbl_surat_masuk', ['status_surat' => 'Didisposisikan'], ['id' => $data['id_surat']]);
        $insert_data_disposisi = $this->crud->insert("tbl_disposisi", $data_disposisi);
        $insert_data_pesan = $this->crud->insert("tbl_pesan", $data_pesan);

        if ($this->db->affected_rows() == true) {
            $this->_log_histori_naskah(
                'masuk',
                $id_surat,
                $data_surat['no_surat'],
                'Teruskan Pesan',
                isset($data['pesan']) ? $data['pesan'] : '',
                $this->session->userdata('name'),
                isset($data_disposisi['penerima']) ? $data_disposisi['penerima'] : null
            );
            $response = ['status' => 'success', 'message' => 'Berhasil Meneruskan Pesan!'];
        } else
            $response = ['status' => 'error', 'message' => 'Gagal Meneruskan Pesan!'];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    private function _sudah_didisposisikan($id_surat, $penerima)
    {
        if ($penerima === '') {
            return false;
        }

        return $this->db
            ->where('id_surat', $id_surat)
            ->where('penerima', $penerima)
            ->count_all_results('tbl_disposisi') > 0;
    }

    public function dokumen_approval_flow()
    {
        $data['title'] = 'SIASEPP KECe | Setting Flow Approval';
        $data['sess_menu'] = 'dokumen_approval_flow';
        $data['apps'] = $this->Crud->get_all('mst_apps')->row_array();
        $this->load->view('template/header', $data);
        $this->load->view('dashboard/dokumen_approval_flow');
        $this->load->view('template/footer');
    }

    public function dokumen_approval_pengajuan()
    {
        $data['title'] = 'SIASEPP KECe | Pengajuan Dokumen Approval';
        $data['sess_menu'] = 'dokumen_approval_pengajuan';
        $data['apps'] = $this->Crud->get_all('mst_apps')->row_array();
        $this->load->view('template/header', $data);
        $this->load->view('dashboard/dokumen_approval_pengajuan');
        $this->load->view('template/footer');
    }

    public function dokumen_approval_report()
    {
        $data['title'] = 'SIASEPP KECe | Report Dokumen Approval';
        $data['sess_menu'] = 'dokumen_approval_report';
        $data['apps'] = $this->Crud->get_all('mst_apps')->row_array();
        $this->load->view('template/header', $data);
        $this->load->view('dashboard/dokumen_approval_report');
        $this->load->view('template/footer');
    }

    public function dokumen_approval_saya()
    {
        $data['title'] = 'SIASEPP KECe | Approval Saya';
        $data['sess_menu'] = 'dokumen_approval_saya';
        $data['apps'] = $this->Crud->get_all('mst_apps')->row_array();
        $this->load->view('template/header', $data);
        $this->load->view('dashboard/dokumen_approval_saya');
        $this->load->view('template/footer');
    }

    public function dokumen_approval_review($request_id = 0)
    {
        $review = $this->_get_doc_approval_review_data((int) $request_id);
        if (!$review) {
            show_error('Data approval tidak ditemukan atau Anda tidak memiliki akses ke dokumen ini.', 404, 'Approval tidak ditemukan');
            return;
        }

        $data['title'] = 'SIASEPP KECe | Review Dokumen Approval';
        $data['sess_menu'] = 'dokumen_approval_saya';
        $data['apps'] = $this->Crud->get_all('mst_apps')->row_array();
        $data['review'] = $review;
        $this->load->view('template/header', $data);
        $this->load->view('dashboard/dokumen_approval_review', $data);
        $this->load->view('template/footer');
    }

    public function dokumen_approval_scan()
    {
        $data['title'] = 'SIASEPP KECe | Scan QR Dokumen Approval';
        $data['sess_menu'] = 'dokumen_approval_scan';
        $data['apps'] = $this->Crud->get_all('mst_apps')->row_array();
        $this->load->view('template/header', $data);
        $this->load->view('dashboard/dokumen_approval_scan');
        $this->load->view('template/footer');
    }

    public function verifikasi_doc_approval($token = '')
    {
        $qrcode = $this->db
            ->where('verification_token', $token)
            ->where('is_active', 1)
            ->get('doc_approval_qrcodes')
            ->row_array();

        $document = null;
        if ($qrcode) {
            $document = $this->db
                ->where('id', $qrcode['document_id'])
                ->where('status', 'approved')
                ->get('doc_approval_documents')
                ->row_array();
        }

        $valid = $qrcode && $document;

        $request = null;
        $approved_by = array();
        $final_file_url = '';

        if ($valid) {
            $request = $this->db
                ->where('id', $qrcode['request_id'])
                ->get('doc_approval_requests')
                ->row_array();

            $approved_by = $this->db
                ->select('approver_name, note, created_at')
                ->where('request_id', $qrcode['request_id'])
                ->where('action', 'approved')
                ->order_by('created_at', 'ASC')
                ->get('doc_approval_actions')
                ->result_array();

            $final_file = !empty($qrcode['final_file']) ? $qrcode['final_file'] : $document['final_file'];
            if (!empty($final_file)) {
                $final_file_url = base_url('assets/dokumen_approval/final/'.$final_file);
            }
        }

        $this->output
            ->set_content_type('text/html')
            ->set_output($this->load->view('dashboard/dokumen_approval_verifikasi', array(
                'valid' => $valid,
                'qrcode' => $qrcode,
                'document' => $document,
                'request' => $request,
                'approved_by' => $approved_by,
                'final_file_url' => $final_file_url
            ), true));
    }

    public function ajax_table_doc_approval_flows()
    {
        $flows = $this->db
            ->select('f.id, f.name, f.document_type, f.description, f.is_active, f.created_at, COUNT(DISTINCT s.id) AS total_step, COUNT(a.id) AS total_approver')
            ->from('doc_approval_flows f')
            ->join('doc_approval_steps s', 's.flow_id = f.id', 'left')
            ->join('doc_approval_step_approvers a', 'a.step_id = s.id', 'left')
            ->group_by('f.id')
            ->order_by('f.id', 'DESC')
            ->get()
            ->result();

        $data = array();
        $no = 1;
        foreach ($flows as $flow) {
            $data[] = array(
                'no' => $no++,
                'id' => $flow->id,
                'name' => $flow->name,
                'document_type' => $flow->document_type,
                'description' => $flow->description,
                'is_active' => $flow->is_active,
                'total_step' => (int) $flow->total_step,
                'total_approver' => (int) $flow->total_approver,
                'steps' => $this->_get_doc_approval_flow_steps($flow->id),
                'created_at' => date('d-F-Y H:i:s', strtotime($flow->created_at))
            );
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('data' => $data)));
    }

    public function get_doc_approval_flows()
    {
        $document_type = $this->input->post('document_type');
        if (!in_array($document_type, array('dokumen'), true)) {
            $document_type = $this->input->get('document_type');
        }

        $this->db
            ->select('id, name, document_type, description')
            ->where('is_active', 1)
            ->order_by('name', 'ASC');

        if (in_array($document_type, array('dokumen'), true)) {
            $this->db->where_in('document_type', array($document_type, 'semua'));
        }

        $flows = $this->db->get('doc_approval_flows')->result_array();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($flows));
    }

    public function ajax_table_doc_approval_pengajuan()
    {
        $rows = $this->db
            ->select('d.*, f.name AS flow_name')
            ->from('doc_approval_documents d')
            ->join('doc_approval_flows f', 'f.id = d.flow_id', 'left')
            ->where('d.submitted_by', $this->session->userdata('userid'))
            ->order_by('d.id', 'DESC')
            ->get()
            ->result();

        $data = array();
        $no = 1;
        foreach ($rows as $row) {
            $data[] = array(
                'no' => $no++,
                'id' => $row->id,
                'title' => $row->title,
                'document_number' => $row->document_number,
                'document_date' => !empty($row->document_date) && $row->document_date !== '0000-00-00' ? date('d-F-Y', strtotime($row->document_date)) : '-',
                'category' => $row->category,
                'summary' => $row->summary,
                'original_file' => $row->original_file,
                'final_file' => $row->final_file,
                'status' => $row->status,
                'flow_id' => $row->flow_id,
                'flow_name' => $row->flow_name,
                'submitted_at' => date('d-F-Y H:i:s', strtotime($row->submitted_at)),
                'completed_at' => $row->completed_at ? date('d-F-Y H:i:s', strtotime($row->completed_at)) : '-',
                'qrcode' => $row->status === 'approved' ? $this->_ensure_doc_approval_qrcode_by_document('dokumen', $row->id) : null,
                'history' => $this->_get_doc_approval_history_by_document('dokumen', $row->id)
            );
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('data' => $data)));
    }

    public function ajax_table_doc_approval_report()
    {
        $status = $this->input->post('status');
        $date_start = $this->input->post('date_start');
        $date_end = $this->input->post('date_end');

        $this->db
            ->select('d.*, f.name AS flow_name, r.current_step_order, r.status AS request_status, s.step_name, s.approval_mode')
            ->from('doc_approval_documents d')
            ->join('doc_approval_flows f', 'f.id = d.flow_id', 'left')
            ->join('doc_approval_requests r', 'r.document_type = "dokumen" AND r.document_id = d.id', 'left')
            ->join('doc_approval_steps s', 's.flow_id = r.flow_id AND s.step_order = r.current_step_order', 'left');

        if ($status !== '') {
            $this->db->where('d.status', $status);
        }

        if ($date_start !== '') {
            $this->db->where('DATE(d.submitted_at) >=', $date_start);
        }

        if ($date_end !== '') {
            $this->db->where('DATE(d.submitted_at) <=', $date_end);
        }

        $rows = $this->db
            ->order_by('d.id', 'DESC')
            ->get()
            ->result();

        $data = array();
        $no = 1;
        foreach ($rows as $row) {
            $data[] = array(
                'no' => $no++,
                'id' => $row->id,
                'title' => $row->title,
                'document_number' => $row->document_number,
                'document_date' => !empty($row->document_date) && $row->document_date !== '0000-00-00' ? date('d-F-Y', strtotime($row->document_date)) : '-',
                'category' => $row->category,
                'summary' => $row->summary,
                'original_file' => $row->original_file,
                'final_file' => $row->final_file,
                'status' => $row->status,
                'flow_id' => $row->flow_id,
                'flow_name' => $row->flow_name,
                'current_step_order' => $row->current_step_order,
                'step_name' => $row->step_name,
                'approval_mode' => $row->approval_mode,
                'submitted_by' => $row->submitted_by,
                'submitted_by_name' => $row->submitted_by_name,
                'submitted_at' => date('d-F-Y H:i:s', strtotime($row->submitted_at)),
                'completed_at' => $row->completed_at ? date('d-F-Y H:i:s', strtotime($row->completed_at)) : '-',
                'qrcode' => $row->status === 'approved' ? $this->_ensure_doc_approval_qrcode_by_document('dokumen', $row->id) : null,
                'history' => $this->_get_doc_approval_history_by_document('dokumen', $row->id)
            );
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('data' => $data)));
    }

    public function simpan_doc_approval_pengajuan()
    {
        $title = trim((string) $this->input->post('title'));
        $document_number = trim((string) $this->input->post('document_number'));
        $document_date = $this->input->post('document_date');
        $category = trim((string) $this->input->post('category'));
        $summary = trim((string) $this->input->post('summary'));
        $flow_id = (int) $this->input->post('flow_id');

        if ($title === '' || $document_number === '' || $document_date === '' || $flow_id <= 0) {
            $this->_json_response('error', 'Judul, nomor dokumen, tanggal dokumen, dan flow approval wajib diisi.');
            return;
        }

        if (empty($_FILES['file']['name'])) {
            $this->_json_response('error', 'File dokumen wajib diupload.');
            return;
        }

        $flow = $this->db->get_where('doc_approval_flows', array('id' => $flow_id, 'is_active' => 1))->row_array();
        $first_step = $this->db->where('flow_id', $flow_id)->order_by('step_order', 'ASC')->get('doc_approval_steps')->row_array();
        if (!$flow || !$first_step || !in_array($flow['document_type'], array('dokumen', 'semua'), true)) {
            $this->_json_response('error', 'Flow approval dokumen tidak valid.');
            return;
        }

        $config['upload_path'] = './assets/dokumen_approval/';
        $config['allowed_types'] = 'pdf|PDF';
        $config['max_size'] = 100024;
        $config['encrypt_name'] = true;

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, true);
        }

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('file')) {
            $this->_json_response('error', $this->upload->display_errors('', ''));
            return;
        }

        $upload = $this->upload->data();

        $this->db->trans_start();
        $this->db->insert('doc_approval_documents', array(
            'title' => $title,
            'document_number' => $document_number,
            'document_date' => $document_date,
            'category' => $category,
            'summary' => $summary,
            'original_file' => $upload['file_name'],
            'status' => 'submitted',
            'flow_id' => $flow_id,
            'submitted_by' => $this->session->userdata('userid'),
            'submitted_by_name' => $this->session->userdata('name'),
            'submitted_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s')
        ));
        $document_id = $this->db->insert_id();

        $this->db->insert('doc_approval_requests', array(
            'document_type' => 'dokumen',
            'document_id' => $document_id,
            'flow_id' => $flow_id,
            'current_step_order' => $first_step['step_order'],
            'status' => 'submitted',
            'submitted_by' => $this->session->userdata('userid'),
            'submitted_by_name' => $this->session->userdata('name'),
            'submitted_at' => date('Y-m-d H:i:s')
        ));
        $this->db->trans_complete();

        $this->_json_response(
            $this->db->trans_status() ? 'success' : 'error',
            $this->db->trans_status() ? 'Dokumen berhasil diajukan approval.' : 'Dokumen gagal diajukan approval.'
        );
    }

    public function simpan_doc_approval_flow()
    {
        $this->_save_doc_approval_flow();
    }

    public function update_doc_approval_flow()
    {
        $this->_save_doc_approval_flow((int) $this->input->post('flow_id'));
    }

    private function _save_doc_approval_flow($flow_id = 0)
    {
        $name = trim((string) $this->input->post('name'));
        $document_type = $this->input->post('document_type');
        $description = trim((string) $this->input->post('description'));
        $steps = $this->input->post('steps');
        $steps = is_array($steps) ? $steps : array();

        if ($name === '' || !in_array($document_type, array('dokumen', 'semua'), true) || empty($steps)) {
            $this->_json_response('error', 'Nama flow, jenis dokumen, dan minimal satu step wajib diisi.');
            return;
        }

        $clean_steps = array();
        foreach ($steps as $step) {
            $step_name = trim((string) (isset($step['name']) ? $step['name'] : ''));
            $mode = strtoupper(trim((string) (isset($step['mode']) ? $step['mode'] : 'ANY')));
            $approvers = isset($step['approvers']) && is_array($step['approvers']) ? array_values(array_unique(array_filter($step['approvers']))) : array();

            if ($step_name === '' || !in_array($mode, array('ANY', 'ALL'), true) || empty($approvers)) {
                $this->_json_response('error', 'Setiap step wajib punya nama, mode ANY/ALL, dan minimal satu approver.');
                return;
            }

            $clean_steps[] = array(
                'name' => $step_name,
                'mode' => $mode,
                'approvers' => $approvers
            );
        }

        if ($flow_id > 0 && !$this->db->get_where('doc_approval_flows', array('id' => $flow_id))->row_array()) {
            $this->_json_response('error', 'Flow approval tidak ditemukan.');
            return;
        }

        $this->db->trans_start();
        $flow_data = array(
            'name' => $name,
            'document_type' => $document_type,
            'description' => $description,
            'is_active' => 1,
            'updated_at' => date('Y-m-d H:i:s')
        );

        if ($flow_id > 0) {
            $this->db->update('doc_approval_flows', $flow_data, array('id' => $flow_id));
            $old_steps = $this->db->select('id')->where('flow_id', $flow_id)->get('doc_approval_steps')->result_array();
            foreach ($old_steps as $old_step) {
                $this->db->delete('doc_approval_step_approvers', array('step_id' => $old_step['id']));
            }
            $this->db->delete('doc_approval_steps', array('flow_id' => $flow_id));
        } else {
            $flow_data['created_by'] = $this->session->userdata('userid');
            $flow_data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('doc_approval_flows', $flow_data);
            $flow_id = $this->db->insert_id();
        }

        foreach ($clean_steps as $index => $step) {
            $this->db->insert('doc_approval_steps', array(
                'flow_id' => $flow_id,
                'step_order' => $index + 1,
                'step_name' => $step['name'],
                'approval_mode' => $step['mode'],
                'created_at' => date('Y-m-d H:i:s')
            ));
            $step_id = $this->db->insert_id();

            foreach ($step['approvers'] as $userid) {
                $user = $this->db->get_where('user', array('userid' => $userid))->row_array();
                if ($user) {
                    $this->db->insert('doc_approval_step_approvers', array(
                        'step_id' => $step_id,
                        'approver_userid' => $user['userid'],
                        'approver_name' => $user['name']
                    ));
                }
            }
        }
        $this->db->trans_complete();

        $this->_json_response(
            $this->db->trans_status() ? 'success' : 'error',
            $this->db->trans_status() ? 'Flow approval berhasil disimpan.' : 'Flow approval gagal disimpan.'
        );
    }

    public function delete_doc_approval_flow()
    {
        $flow_id = (int) $this->input->post('id');
        $used = $this->db->where('flow_id', $flow_id)->count_all_results('doc_approval_requests');
        if ($used > 0) {
            $this->_json_response('error', 'Flow sudah dipakai pada pengajuan approval dan tidak bisa dihapus.');
            return;
        }

        $steps = $this->db->select('id')->where('flow_id', $flow_id)->get('doc_approval_steps')->result_array();
        $this->db->trans_start();
        foreach ($steps as $step) {
            $this->db->delete('doc_approval_step_approvers', array('step_id' => $step['id']));
        }
        $this->db->delete('doc_approval_steps', array('flow_id' => $flow_id));
        $this->db->delete('doc_approval_flows', array('id' => $flow_id));
        $this->db->trans_complete();

        $this->_json_response(
            $this->db->trans_status() ? 'success' : 'error',
            $this->db->trans_status() ? 'Flow approval berhasil dihapus.' : 'Flow approval gagal dihapus.'
        );
    }

    public function ajax_table_doc_approval_saya()
    {
        $userid = $this->session->userdata('userid');
        $rows = $this->db
            ->select('r.id AS request_id, r.document_type, r.document_id, r.current_step_order, r.status AS request_status, r.submitted_by_name, r.submitted_at, r.completed_at, f.name AS flow_name, us.id AS step_id, us.step_name, us.approval_mode, us.step_order, act.action AS my_action')
            ->from('doc_approval_requests r')
            ->join('doc_approval_flows f', 'f.id = r.flow_id')
            ->join('doc_approval_steps us', 'us.flow_id = r.flow_id')
            ->join('doc_approval_step_approvers a', 'a.step_id = us.id')
            ->join('doc_approval_actions act', 'act.request_id = r.id AND act.step_id = us.id AND act.approver_userid = a.approver_userid', 'left')
            ->where('a.approver_userid', $userid)
            ->where("((r.status IN ('submitted', 'in_review') AND us.step_order = r.current_step_order) OR act.id IS NOT NULL)", null, false)
            ->order_by('r.submitted_at', 'DESC')
            ->get()
            ->result();

        $data = array();
        $no = 1;
        foreach ($rows as $row) {
            $document = $this->_get_doc_approval_document($row->document_type, $row->document_id);
            $data[] = array(
                'no' => $no++,
                'request_id' => $row->request_id,
                'step_id' => $row->step_id,
                'document_type' => $row->document_type,
                'document_id' => $row->document_id,
                'flow_name' => $row->flow_name,
                'step_name' => $row->step_name,
                'approval_mode' => $row->approval_mode,
                'request_status' => $row->request_status,
                'submitted_by_name' => $row->submitted_by_name,
                'submitted_at' => date('d-F-Y H:i:s', strtotime($row->submitted_at)),
                'completed_at' => $row->completed_at ? date('d-F-Y H:i:s', strtotime($row->completed_at)) : '-',
                'document' => $document,
                'history' => $this->_get_doc_approval_history($row->request_id),
                'qrcode' => $document && $document['status'] === 'approved' ? $this->_ensure_doc_approval_qrcode_by_document($row->document_type, $row->document_id) : null,
                'my_action' => $row->my_action ? $row->my_action : ''
            );
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('data' => $data)));
    }

    public function proses_doc_approval()
    {
        $request_id = (int) $this->input->post('request_id');
        $step_id = (int) $this->input->post('step_id');
        $action = $this->input->post('action');
        $note = trim((string) $this->input->post('note'));
        $userid = $this->session->userdata('userid');

        if (!in_array($action, array('approved', 'rejected', 'revision_required'), true)) {
            $this->_json_response('error', 'Aksi approval tidak valid.');
            return;
        }

        $request = $this->db->get_where('doc_approval_requests', array('id' => $request_id))->row_array();
        $step = $this->db->get_where('doc_approval_steps', array('id' => $step_id))->row_array();
        $approver = $this->db->get_where('doc_approval_step_approvers', array(
            'step_id' => $step_id,
            'approver_userid' => $userid
        ))->row_array();

        if (!$request || !$step || !$approver || !in_array($request['status'], array('submitted', 'in_review'), true)) {
            $this->_json_response('error', 'Data approval tidak ditemukan atau sudah selesai.');
            return;
        }

        if ((int) $request['flow_id'] !== (int) $step['flow_id'] || (int) $request['current_step_order'] !== (int) $step['step_order']) {
            $this->_json_response('error', 'Step approval ini bukan posisi approval aktif.');
            return;
        }

        $exists = $this->db
            ->where('request_id', $request_id)
            ->where('step_id', $step_id)
            ->where('approver_userid', $userid)
            ->count_all_results('doc_approval_actions');
        if ($exists > 0) {
            $this->_json_response('error', 'Anda sudah memproses step approval ini.');
            return;
        }

        $this->db->trans_start();
        $this->db->insert('doc_approval_actions', array(
            'request_id' => $request_id,
            'step_id' => $step_id,
            'approver_userid' => $approver['approver_userid'],
            'approver_name' => $approver['approver_name'],
            'action' => $action,
            'note' => $note,
            'created_at' => date('Y-m-d H:i:s')
        ));

        if ($action === 'rejected' || $action === 'revision_required') {
            $this->db->update('doc_approval_requests', array(
                'status' => $action,
                'completed_at' => date('Y-m-d H:i:s')
            ), array('id' => $request_id));
            $this->_sync_doc_approval_document_status($request, $action);
        } elseif ($this->_is_doc_approval_step_completed($request_id, $step_id, $step['approval_mode'])) {
            $this->_move_doc_approval_to_next_step($request, $step);
        } else {
            $this->db->update('doc_approval_requests', array('status' => 'in_review'), array('id' => $request_id));
            $this->_sync_doc_approval_document_status($request, 'in_review');
        }

        $this->db->trans_complete();

        $this->_json_response(
            $this->db->trans_status() ? 'success' : 'error',
            $this->db->trans_status() ? 'Approval berhasil diproses.' : 'Approval gagal diproses.'
        );
    }

    private function _get_doc_approval_review_data($request_id)
    {
        $userid = $this->session->userdata('userid');
        $row = $this->db
            ->select('r.id AS request_id, r.document_type, r.document_id, r.current_step_order, r.status AS request_status, r.submitted_by_name, r.submitted_at, f.name AS flow_name, us.id AS step_id, us.step_name, us.approval_mode, us.step_order, act.action AS my_action')
            ->from('doc_approval_requests r')
            ->join('doc_approval_flows f', 'f.id = r.flow_id')
            ->join('doc_approval_steps us', 'us.flow_id = r.flow_id')
            ->join('doc_approval_step_approvers a', 'a.step_id = us.id')
            ->join('doc_approval_actions act', 'act.request_id = r.id AND act.step_id = us.id AND act.approver_userid = a.approver_userid', 'left')
            ->where('r.id', $request_id)
            ->where('a.approver_userid', $userid)
            ->where("((r.status IN ('submitted', 'in_review') AND us.step_order = r.current_step_order) OR act.id IS NOT NULL)", null, false)
            ->get()
            ->row_array();

        if (!$row) {
            return null;
        }

        $document = $this->_get_doc_approval_document($row['document_type'], $row['document_id']);
        if (!$document) {
            return null;
        }

        $row['document'] = $document;
        $row['history'] = $this->_get_doc_approval_history($row['request_id']);
        $row['my_action'] = $row['my_action'] ? $row['my_action'] : '';
        $row['is_current_approver'] = (int) $row['step_order'] === (int) $row['current_step_order'];
        $row['submitted_at_label'] = date('d-F-Y H:i:s', strtotime($row['submitted_at']));
        $row['file_url'] = !empty($document['original_file']) ? base_url('assets/dokumen_approval/'.$document['original_file']) : '';

        return $row;
    }

    public function submit_doc_approval()
    {
        $document_type = $this->input->post('document_type');
        $document_id = (int) $this->input->post('document_id');
        $flow_id = (int) $this->input->post('flow_id');

        if (!in_array($document_type, array('dokumen'), true) || $document_id <= 0 || $flow_id <= 0) {
            $this->_json_response('error', 'Dokumen dan flow approval wajib dipilih.');
            return;
        }

        if (!$this->_get_doc_approval_document($document_type, $document_id)) {
            $this->_json_response('error', 'Dokumen tidak ditemukan.');
            return;
        }

        $flow = $this->db->get_where('doc_approval_flows', array('id' => $flow_id, 'is_active' => 1))->row_array();
        $first_step = $this->db->where('flow_id', $flow_id)->order_by('step_order', 'ASC')->get('doc_approval_steps')->row_array();
        if (!$flow || !$first_step || !in_array($flow['document_type'], array($document_type, 'semua'), true)) {
            $this->_json_response('error', 'Flow approval tidak sesuai dengan jenis dokumen.');
            return;
        }

        $exists = $this->db
            ->where('document_type', $document_type)
            ->where('document_id', $document_id)
            ->where_in('status', array('submitted', 'in_review', 'approved'))
            ->count_all_results('doc_approval_requests');
        if ($exists > 0) {
            $this->_json_response('error', 'Dokumen ini sudah pernah diajukan approval.');
            return;
        }

        $this->db->insert('doc_approval_requests', array(
            'document_type' => $document_type,
            'document_id' => $document_id,
            'flow_id' => $flow_id,
            'current_step_order' => $first_step['step_order'],
            'status' => 'submitted',
            'submitted_by' => $this->session->userdata('userid'),
            'submitted_by_name' => $this->session->userdata('name'),
            'submitted_at' => date('Y-m-d H:i:s')
        ));

        $this->_json_response('success', 'Dokumen berhasil diajukan approval.');
    }

    private function _get_latest_doc_approval_request($document_type, $document_id)
    {
        $request = $this->db
            ->select('r.id, r.status, r.current_step_order, r.submitted_at, r.completed_at, f.name AS flow_name, s.step_name, s.approval_mode')
            ->from('doc_approval_requests r')
            ->join('doc_approval_flows f', 'f.id = r.flow_id', 'left')
            ->join('doc_approval_steps s', 's.flow_id = r.flow_id AND s.step_order = r.current_step_order', 'left')
            ->where('r.document_type', $document_type)
            ->where('r.document_id', $document_id)
            ->order_by('r.id', 'DESC')
            ->get()
            ->row_array();

        if (!$request) {
            return array(
                'id' => null,
                'status' => 'belum_diajukan',
                'label' => 'Belum Diajukan',
                'flow_name' => '',
                'step_name' => '',
                'approval_mode' => ''
            );
        }

        $labels = array(
            'draft' => 'Draft',
            'submitted' => 'Diajukan',
            'in_review' => 'Review',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'revision_required' => 'Perlu Revisi',
            'cancelled' => 'Dibatalkan'
        );

        $request['label'] = isset($labels[$request['status']]) ? $labels[$request['status']] : $request['status'];

        return $request;
    }

    private function _get_doc_approval_flow_steps($flow_id)
    {
        $steps = $this->db
            ->where('flow_id', $flow_id)
            ->order_by('step_order', 'ASC')
            ->get('doc_approval_steps')
            ->result_array();

        foreach ($steps as &$step) {
            $step['approvers'] = $this->db
                ->where('step_id', $step['id'])
                ->order_by('id', 'ASC')
                ->get('doc_approval_step_approvers')
                ->result_array();
        }

        return $steps;
    }

    private function _get_doc_approval_document($document_type, $document_id)
    {
        if ($document_type === 'dokumen') {
            return $this->db
                ->select('id, document_number, document_number AS no_surat, title, title AS pihak, document_date, document_date AS tanggal_surat, category, category AS unit, category AS indeks, status AS sifat, summary, summary AS ringkasan_surat, original_file, original_file AS nama_file, final_file, status')
                ->where('id', $document_id)
                ->get('doc_approval_documents')
                ->row_array();
        }

        return null;
    }

    private function _get_doc_approval_history($request_id)
    {
        $request = $this->db
            ->select('id, flow_id')
            ->where('id', $request_id)
            ->get('doc_approval_requests')
            ->row_array();

        if (!$request) {
            return array();
        }

        return $this->db
            ->select('s.id AS step_id, s.step_order, s.step_name, s.approval_mode, ap.approver_userid, ap.approver_name, a.action, a.note, a.created_at')
            ->from('doc_approval_steps s')
            ->join('doc_approval_step_approvers ap', 'ap.step_id = s.id')
            ->join('doc_approval_actions a', 'a.request_id = '.(int) $request_id.' AND a.step_id = s.id AND a.approver_userid = ap.approver_userid', 'left')
            ->where('s.flow_id', $request['flow_id'])
            ->order_by('s.step_order', 'ASC')
            ->order_by('ap.id', 'ASC')
            ->get()
            ->result_array();
    }

    private function _get_doc_approval_history_by_document($document_type, $document_id)
    {
        $request = $this->db
            ->select('id')
            ->where('document_type', $document_type)
            ->where('document_id', $document_id)
            ->order_by('id', 'DESC')
            ->get('doc_approval_requests')
            ->row_array();

        return $request ? $this->_get_doc_approval_history($request['id']) : array();
    }

    private function _is_doc_approval_step_completed($request_id, $step_id, $approval_mode)
    {
        $approved = $this->db
            ->select('approver_userid')
            ->where('request_id', $request_id)
            ->where('step_id', $step_id)
            ->where('action', 'approved')
            ->group_by('approver_userid')
            ->get('doc_approval_actions')
            ->num_rows();

        if ($approval_mode === 'ANY') {
            return $approved > 0;
        }

        $total_approver = $this->db
            ->where('step_id', $step_id)
            ->count_all_results('doc_approval_step_approvers');

        return $total_approver > 0 && $approved >= $total_approver;
    }

    private function _move_doc_approval_to_next_step($request, $current_step)
    {
        $next_step = $this->db
            ->where('flow_id', $request['flow_id'])
            ->where('step_order >', $current_step['step_order'])
            ->order_by('step_order', 'ASC')
            ->get('doc_approval_steps')
            ->row_array();

        if ($next_step) {
            $this->db->update('doc_approval_requests', array(
                'current_step_order' => $next_step['step_order'],
                'status' => 'in_review'
            ), array('id' => $request['id']));
            $this->_sync_doc_approval_document_status($request, 'in_review');
            return;
        }

        $this->db->update('doc_approval_requests', array(
            'status' => 'approved',
            'completed_at' => date('Y-m-d H:i:s')
        ), array('id' => $request['id']));
        $this->_sync_doc_approval_document_status($request, 'approved');
        $this->_ensure_doc_approval_qrcode($request);
    }

    private function _sync_doc_approval_document_status($request, $status)
    {
        if (!isset($request['document_type']) || $request['document_type'] !== 'dokumen') {
            return;
        }

        $data = array(
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        );

        if (in_array($status, array('approved', 'rejected', 'revision_required'), true)) {
            $data['completed_at'] = date('Y-m-d H:i:s');
        }

        $this->db->update('doc_approval_documents', $data, array('id' => $request['document_id']));
    }

    private function _ensure_doc_approval_qrcode($request)
    {
        if (!isset($request['document_type']) || $request['document_type'] !== 'dokumen') {
            return null;
        }

        $existing = $this->_get_doc_approval_qrcode_by_document($request['document_type'], $request['document_id']);
        if ($existing) {
            $this->_ensure_doc_approval_final_pdf($request, $existing);
            return $existing;
        }

        $token = $this->_generate_doc_approval_token();
        $this->db->insert('doc_approval_qrcodes', array(
            'request_id' => $request['id'],
            'document_type' => $request['document_type'],
            'document_id' => $request['document_id'],
            'verification_token' => $token,
            'qr_path' => null,
            'final_file' => null,
            'is_active' => 1,
            'generated_by' => $this->session->userdata('userid'),
            'generated_at' => date('Y-m-d H:i:s')
        ));

        $qrcode = $this->_get_doc_approval_qrcode_by_document($request['document_type'], $request['document_id']);
        $this->_ensure_doc_approval_final_pdf($request, $qrcode);

        return $this->_get_doc_approval_qrcode_by_document($request['document_type'], $request['document_id']);
    }

    private function _ensure_doc_approval_qrcode_by_document($document_type, $document_id)
    {
        $existing = $this->_get_doc_approval_qrcode_by_document($document_type, $document_id);
        if ($existing) {
            $request = $this->db
                ->where('document_type', $document_type)
                ->where('document_id', $document_id)
                ->where('status', 'approved')
                ->order_by('id', 'DESC')
                ->get('doc_approval_requests')
                ->row_array();

            if ($request) {
                $this->_ensure_doc_approval_final_pdf($request, $existing);
                return $this->_get_doc_approval_qrcode_by_document($document_type, $document_id);
            }

            return $existing;
        }

        $request = $this->db
            ->where('document_type', $document_type)
            ->where('document_id', $document_id)
            ->where('status', 'approved')
            ->order_by('id', 'DESC')
            ->get('doc_approval_requests')
            ->row_array();

        return $request ? $this->_ensure_doc_approval_qrcode($request) : null;
    }

    private function _get_doc_approval_qrcode_by_document($document_type, $document_id)
    {
        $qrcode = $this->db
            ->where('document_type', $document_type)
            ->where('document_id', $document_id)
            ->where('is_active', 1)
            ->order_by('id', 'DESC')
            ->get('doc_approval_qrcodes')
            ->row_array();

        if (!$qrcode) {
            return null;
        }

        $verification_url = base_url('dashboard/verifikasi_doc_approval/'.$qrcode['verification_token']);
        $qrcode['verification_url'] = $verification_url;
        $qrcode['qr_image_url'] = !empty($qrcode['qr_path'])
            ? base_url('assets/dokumen_approval/qrcode/'.$qrcode['qr_path'])
            : 'https://api.qrserver.com/v1/create-qr-code/?size=130x130&data='.rawurlencode($verification_url);
        $qrcode['final_file_url'] = !empty($qrcode['final_file'])
            ? base_url('assets/dokumen_approval/final/'.$qrcode['final_file'])
            : null;

        return $qrcode;
    }

    private function _ensure_doc_approval_final_pdf($request, $qrcode)
    {
        if (!$qrcode || !isset($request['document_type']) || $request['document_type'] !== 'dokumen') {
            return false;
        }

        if (!empty($qrcode['final_file']) && file_exists(FCPATH.'assets/dokumen_approval/final/'.$qrcode['final_file'])) {
            return true;
        }

        $document = $this->db
            ->where('id', $request['document_id'])
            ->get('doc_approval_documents')
            ->row_array();

        if (!$document || empty($document['original_file'])) {
            return false;
        }

        $source_file = FCPATH.'assets/dokumen_approval/'.$document['original_file'];
        if (!file_exists($source_file)) {
            return false;
        }

        $qr_file = $this->_ensure_doc_approval_qrcode_file($qrcode);
        if (!$qr_file || !file_exists($qr_file)) {
            return false;
        }

        $autoload = FCPATH.'vendor/autoload.php';
        if (!file_exists($autoload)) {
            return false;
        }

        require_once $autoload;

        if (!class_exists('\\setasign\\Fpdi\\Fpdi')) {
            return false;
        }

        $final_dir = FCPATH.'assets/dokumen_approval/final/';
        if (!is_dir($final_dir)) {
            @mkdir($final_dir, 0755, true);
        }

        $final_file = 'approved_'.$document['id'].'_'.$qrcode['verification_token'].'.pdf';
        $final_path = $final_dir.$final_file;

        try {
            $pdf = new \setasign\Fpdi\Fpdi();
            $page_count = $pdf->setSourceFile($source_file);

            for ($page_no = 1; $page_no <= $page_count; $page_no++) {
                $template_id = $pdf->importPage($page_no);
                $size = $pdf->getTemplateSize($template_id);
                $orientation = $size['width'] > $size['height'] ? 'L' : 'P';

                $pdf->AddPage($orientation, array($size['width'], $size['height']));
                $pdf->useTemplate($template_id);

                if ($page_no === 1) {
                    $qr_size = 35;
                    $margin_right = 12;
                    $margin_bottom = 12;
                    $x = $size['width'] - $qr_size - $margin_right;
                    $y = $size['height'] - $qr_size - $margin_bottom;
                    $pdf->Image($qr_file, $x, $y, $qr_size, $qr_size);
                }
            }

            $pdf->Output('F', $final_path);
        } catch (Exception $e) {
            log_message('error', 'Gagal membuat PDF final approval: '.$e->getMessage());
            if (!$this->_generate_doc_approval_final_pdf_with_python($source_file, $qr_file, $final_path)) {
                return false;
            }
        }

        if (!file_exists($final_path)) {
            return false;
        }

        $qr_name = basename($qr_file);
        $this->db->update('doc_approval_qrcodes', array(
            'qr_path' => $qr_name,
            'final_file' => $final_file
        ), array('id' => $qrcode['id']));

        $this->db->update('doc_approval_documents', array(
            'final_file' => $final_file,
            'updated_at' => date('Y-m-d H:i:s')
        ), array('id' => $document['id']));

        return true;
    }

    private function _ensure_doc_approval_qrcode_file($qrcode)
    {
        $qr_dir = FCPATH.'assets/dokumen_approval/qrcode/';
        if (!is_dir($qr_dir)) {
            @mkdir($qr_dir, 0755, true);
        }

        $qr_name = !empty($qrcode['qr_path']) ? $qrcode['qr_path'] : $qrcode['verification_token'].'.png';
        $qr_path = $qr_dir.$qr_name;

        if (file_exists($qr_path)) {
            $this->_apply_doc_approval_logo_to_qrcode($qr_path);
            return $qr_path;
        }

        $verification_url = base_url('dashboard/verifikasi_doc_approval/'.$qrcode['verification_token']);
        $qr_url = 'https://api.qrserver.com/v1/create-qr-code/?size=600x600&ecc=H&margin=20&data='.rawurlencode($verification_url);
        $qr_binary = @file_get_contents($qr_url);

        if ($qr_binary === false || $qr_binary === '') {
            return false;
        }

        if (@file_put_contents($qr_path, $qr_binary) === false) {
            return false;
        }

        $this->_apply_doc_approval_logo_to_qrcode($qr_path);

        return $qr_path;
    }

    private function _apply_doc_approval_logo_to_qrcode($qr_path)
    {
        $logo_path = FCPATH.'assets/dist/img/logo_ww.png';
        if (!extension_loaded('gd') || !file_exists($qr_path) || !file_exists($logo_path)) {
            return false;
        }

        $qr = @imagecreatefrompng($qr_path);
        $logo = @imagecreatefrompng($logo_path);

        if (!$qr || !$logo) {
            if ($qr) {
                imagedestroy($qr);
            }
            if ($logo) {
                imagedestroy($logo);
            }
            return false;
        }

        imagealphablending($qr, true);
        imagesavealpha($qr, true);

        $qr_width = imagesx($qr);
        $qr_height = imagesy($qr);
        $logo_width = imagesx($logo);
        $logo_height = imagesy($logo);

        $target_width = (int) round($qr_width * 0.16);
        $target_height = (int) round($logo_height * ($target_width / $logo_width));

        if ($target_height > (int) round($qr_height * 0.16)) {
            $target_height = (int) round($qr_height * 0.16);
            $target_width = (int) round($logo_width * ($target_height / $logo_height));
        }

        $padding = (int) round($qr_width * 0.025);
        $bg_width = $target_width + ($padding * 2);
        $bg_height = $target_height + ($padding * 2);
        $bg_x = (int) round(($qr_width - $bg_width) / 2);
        $bg_y = (int) round(($qr_height - $bg_height) / 2);
        $logo_x = $bg_x + $padding;
        $logo_y = $bg_y + $padding;

        $white = imagecolorallocate($qr, 255, 255, 255);
        imagefilledrectangle($qr, $bg_x, $bg_y, $bg_x + $bg_width, $bg_y + $bg_height, $white);
        imagecopyresampled($qr, $logo, $logo_x, $logo_y, 0, 0, $target_width, $target_height, $logo_width, $logo_height);

        $saved = imagepng($qr, $qr_path);

        imagedestroy($qr);
        imagedestroy($logo);

        return $saved;
    }

    private function _generate_doc_approval_final_pdf_with_python($source_file, $qr_file, $final_path)
    {
        $script = FCPATH.'application/helpers/doc_approval_pdf_stamp.py';
        if (!file_exists($script)) {
            return false;
        }

        $command = 'py '.escapeshellarg($script).' '.escapeshellarg($source_file).' '.escapeshellarg($qr_file).' '.escapeshellarg($final_path);
        $output = array();
        $exit_code = 0;
        @exec($command, $output, $exit_code);

        if ($exit_code !== 0) {
            log_message('error', 'Fallback Python PDF approval gagal: '.implode("\n", $output));
            return false;
        }

        return file_exists($final_path);
    }

    private function _generate_doc_approval_token()
    {
        do {
            if (function_exists('random_bytes')) {
                $token = bin2hex(random_bytes(24));
            } else {
                $token = sha1(uniqid('', true).mt_rand());
            }

            $exists = $this->db
                ->where('verification_token', $token)
                ->count_all_results('doc_approval_qrcodes');
        } while ($exists > 0);

        return $token;
    }

    private function _json_response($status, $message, $extra = array())
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array_merge(array(
                'status' => $status,
                'message' => $message
            ), $extra)));
    }


    public function surat_keluar()
    {
        $data['title'] = 'SIASEPP KECe | User';
        $data['sess_menu'] = 'surat_keluar';
        $data['apps'] = $this->Crud->get_all('mst_apps')->row_array();
        $this->load->view('template/header', $data);
        $this->load->view('dashboard/surat_keluar');
        $this->load->view('template/footer');
    }

    public function approval_naskah_keluar()
    {
        $data['title'] = 'SIASEPP KECe | Approval Naskah Keluar';
        $data['sess_menu'] = 'approval_naskah_keluar';
        $data['apps'] = $this->Crud->get_all('mst_apps')->row_array();
        $this->load->view('template/header', $data);
        $this->load->view('dashboard/approval_naskah_keluar');
        $this->load->view('template/footer');
    }

    public function ajax_table_approval_naskah_keluar()
    {
        $rows = $this->db
            ->select('a.id AS approval_id, a.urutan, a.status AS status_approval_detail, a.catatan, sk.id, sk.no_surat, sk.tujuan, sk.tanggal_surat, sk.unit_pengirim, sk.indeks, sk.sifat, sk.ringkasan_surat, sk.nama_file, sk.status_approval, sk.date_created')
            ->from('tbl_approval_naskah_keluar a')
            ->join('tbl_surat_keluar sk', 'sk.id = a.id_surat_keluar')
            ->where('a.approver_userid', $this->session->userdata('userid'))
            ->order_by('a.date_created', 'DESC')
            ->get()
            ->result();

        $data = array();
        $no = 1;
        foreach ($rows as $row) {
            $data[] = array(
                'no' => $no++,
                'approval_id' => $row->approval_id,
                'id' => $row->id,
                'no_surat' => $row->no_surat,
                'tujuan' => $row->tujuan,
                'tanggal_surat' => !empty($row->tanggal_surat) && $row->tanggal_surat !== '0000-00-00' ? date('d-F-Y', strtotime($row->tanggal_surat)) : '-',
                'unit_pengirim' => $row->unit_pengirim,
                'indeks' => $row->indeks,
                'sifat' => $row->sifat,
                'ringkasan_surat' => $row->ringkasan_surat,
                'nama_file' => $row->nama_file,
                'urutan' => $row->urutan,
                'status_approval' => $row->status_approval,
                'status_approval_detail' => $row->status_approval_detail,
                'approval_detail' => $this->_get_approval_naskah_keluar($row->id),
                'date_created' => date('d-F-Y H:i:s', strtotime($row->date_created))
            );
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('data' => $data)));
    }

    public function proses_approval_naskah_keluar()
    {
        $approval_id = $this->input->post('approval_id');
        $status = $this->input->post('status');
        $catatan = trim((string) $this->input->post('catatan'));

        if (!in_array($status, array('Disetujui', 'Ditolak'), true)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('status' => 'error', 'message' => 'Status approval tidak valid.')));
            return;
        }

        $approval = $this->db->get_where('tbl_approval_naskah_keluar', array(
            'id' => $approval_id,
            'approver_userid' => $this->session->userdata('userid')
        ))->row_array();

        if (!$approval) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('status' => 'error', 'message' => 'Data approval tidak ditemukan.')));
            return;
        }

        $this->db->update('tbl_approval_naskah_keluar', array(
            'status' => $status,
            'catatan' => $catatan,
            'approved_at' => date('Y-m-d H:i:s')
        ), array('id' => $approval_id));

        $id_surat = $approval['id_surat_keluar'];
        if ($status === 'Ditolak') {
            $this->db->update('tbl_surat_keluar', array('status_approval' => 'Ditolak'), array('id' => $id_surat));
        } else {
            $pending = $this->db
                ->where('id_surat_keluar', $id_surat)
                ->where('status <>', 'Disetujui')
                ->count_all_results('tbl_approval_naskah_keluar');
            $this->db->update('tbl_surat_keluar', array('status_approval' => $pending > 0 ? 'Menunggu Approval' : 'Disetujui'), array('id' => $id_surat));
        }

        $surat = $this->db->get_where('tbl_surat_keluar', array('id' => $id_surat))->row_array();
        if ($surat) {
            $this->_log_histori_naskah(
                'keluar',
                $id_surat,
                $surat['no_surat'],
                'Approval '.$status,
                $catatan,
                $this->session->userdata('name'),
                $surat['unit_pengirim']
            );
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('status' => 'success', 'message' => 'Approval berhasil diproses.')));
    }

    public function ajax_table_surat_keluar()
    {

        $table = 'tbl_surat_keluar'; //nama tabel dari database
        $column_order = array('id', 'tujuan', 'no_surat', 'tanggal_surat', 'unit_pengirim', 'indeks', 'sifat', 'status_approval', 'date_created'); //field yang ada di table user
        $column_search = array('id', 'tujuan', 'no_surat', 'tanggal_surat', 'unit_pengirim', 'indeks', 'sifat', 'status_approval', 'date_created'); //field yang diizin untuk pencarian 
        $select = 'id, tujuan, no_surat, tanggal_surat, unit_pengirim, indeks, sifat, status_approval, template_approval_id, date_created';
        $order = array('id' => 'asc'); // default order 
        $list = $this->crud->get_datatables($table, $select, $column_order, $column_search, $order);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row['data']['no'] = $no;
            $row['data']['id'] = $key->id;
            $row['data']['tujuan'] = $key->tujuan;
            $row['data']['no_surat'] = $key->no_surat;
            $row['data']['tanggal_surat'] = date('d M, y', strtotime($key->tanggal_surat));
            $row['data']['unit_pengirim'] = $key->unit_pengirim;
            $row['data']['indeks'] = $key->indeks;
            $row['data']['sifat'] = $key->sifat;
            $row['data']['status_approval'] = $key->status_approval;
            $row['data']['template_approval_id'] = $key->template_approval_id;
            $row['data']['date_created'] = date('d-F-Y H:i:s', strtotime($key->date_created));

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->crud->count_all($table),
            "recordsFiltered" => $this->crud->count_filtered($table, $select, $column_order, $column_search, $order),
            "data" => $data,
            "query" => $this->db->last_query()
        );
        //output to json format
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($output));
    }

    public function getsuratmasuk()
    {
        $result = $this->crud->count_all('tbl_surat_masuk');

        echo json_encode($result);
    }

    public function getcountagenda()
    {
        $where = array(
            'nomor_agenda' => ''
        );

        $result = $this->crud->count_where('tbl_disposisi', $where);

        echo json_encode($result);
    }

    public function getsuratkeluar()
    {
        $result = $this->crud->count_all('tbl_surat_keluar');

        echo json_encode($result);
    }

    public function getdisposisi()
    {
        $result = $this->crud->count_all('tbl_disposisi');

        echo json_encode($result);
    }

    public function update_mstapps()
    {
        //ambil nama file
        // $temp_filename = basename($_FILES["lowongan"]["name"]);

        $config['upload_path']          = './assets/dist/img/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG';
        // $config['file_name']            = $this->upload->data();
        // $config['file_name']            = $temp_filename;
        $config['overwrite']            = true;
        $config['max_size']             = 0; // unlimited
        $config['max_width']            = 0;
        $config['max_height']           = 0;
        $config['encrypt_name']         = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('customFile')) {
            redirect('dashboard/settingapps');
        } else {
            $uploaded = $this->upload->data();

            $judul_login = $this->input->post('judul_login');
            $sub_judul = $this->input->post('sub_judul');
            $nama_aplikasi = $this->input->post('nama_aplikasi');

            $table = 'mst_apps';
            $where = array(
                'id' => '1'
            );
            $data = array(
                'judul_login' => $judul_login,
                'subjudul' => $sub_judul,
                'nama_aplikasi' => $nama_aplikasi,
                'logo' => $uploaded['file_name'],
            );
            $this->crud->update($table, $data, $where);
            redirect('dashboard/settingapps');
        }
    }

    public function ubahpassword()
    {
        //cek dlu apakah password tidak sama
        $a = $this->input->post('password');
        $b = $this->input->post('konfirmasi_password');

        if ($a != $b) {
            $result = ['status' => '500', 'message' => 'Password tidak sama!'];
        } else {
            $data = array(
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            );
            $where = array(
                'userid' => $this->session->userdata('userid')
            );

            $this->crud->update('user', $data, $where);
            if ($this->db->affected_rows() == true) {
                $result = ['status' => '200', 'message' => 'Berhasil ubah password!'];
            } else {
                $result = ['status' => '400', 'message' => 'Gagal ubah password!'];
            }
        }
        echo json_encode($result);
    }

    public function edituser()
    {
        $table = $this->input->post('table');
        $where = array(
            'id' => $this->input->post('id')
        );

        $result = $this->crud->get_where($table, $where)->result();


        echo json_encode($result);
    }

    public function getrincian()
    {
        $table = $this->input->post('table');
        $where = array(
            'id' => $this->input->post('id')
        );

        $result = $this->crud->get_where($table, $where)->result();

        echo json_encode($result);
    }

    public function getdisposisidata()
    {
        $where = array(
            'id_surat' => $this->input->post('id')
        );

        $result = $this->db
            ->select('MIN(id) AS id, id_surat, no_surat, pengirim, penerima, MIN(date_created) AS date_created, nomor_agenda, is_read')
            ->where($where)
            ->group_by('id_surat, penerima')
            ->order_by('id', 'ASC')
            ->get('tbl_disposisi')
            ->result();

        echo json_encode($result);
    }

    public function ajax_getdata()
    {
        $data_select = $this->input->post('select_data');
        $where = null;
        if ($this->input->post('where') !== null)
            $where = $this->input->post('where');

        $select = '';
        foreach ($data_select as $key => $value) {
            $select .= $value . ",";
        }
        $select = substr($select, 0, -1);

        $table = $this->input->post('table'); //nama tabel dari database
        $column_order = $data_select;
        $column_search = $data_select;
        $order = null; // default order 
        // $order = array('id' => 'asc'); // default order 
        $list = $this->crud->get_datatables($table, $select, $column_order, $column_search, $order, $where);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row['data']['no'] = $no;
            // $row['data']['id'] = $key->id;
            foreach ($data_select as $data_key => $data_value) {
                $row['data'][$data_value] = $key->$data_value;
            }

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->crud->count_all($table),
            "recordsFiltered" => $this->crud->count_filtered($table, $select, $column_order, $column_search, $order, $where),
            "data" => $data,
            "query" => $this->db->last_query()
        );
        //output to json format
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($output));
    }

    public function update_is_read()
    {
        $id = $this->input->post('id');
        $table = $this->input->post('table');

        $update = $this->crud->update($table, ['is_read' => 'YES'], ['id' => $id]);

        if ($update > 0) {
            if ($table === 'tbl_pesan') {
                $pesan = $this->db->get_where('tbl_pesan', array('id' => $id))->row_array();
                if ($pesan) {
                    $surat = $this->db->get_where('tbl_surat_masuk', array('id' => $pesan['id_surat_masuk']))->row_array();
                    $this->_log_histori_naskah(
                        'masuk',
                        $pesan['id_surat_masuk'],
                        $surat ? $surat['no_surat'] : '',
                        'Pesan Dibaca',
                        'Pesan dibuka oleh '.$this->session->userdata('name'),
                        $pesan['pengirim'],
                        $pesan['penerima']
                    );
                }
            }
            $response = ['status' => 'success', 'message' => 'Berhasil Update Data!'];
        } else
            $response = ['status' => 'error', 'message' => 'Gagal Update Data!'];

        echo json_encode($response);
    }

    public function update_disposisi_is_read()
    {
        $id_surat = $this->input->post('id_surat');
        $table = $this->input->post('table');
        $pengirim = $this->input->post('pengirim');
        $penerima = $this->input->post('penerima');

        $update = $this->crud->update($table, ['is_read' => 'YES'], ['id_surat' => $id_surat, 'pengirim' => $pengirim, 'penerima' => $penerima]);

        if ($update > 0) {
            $response = ['status' => 'success', 'message' => 'Berhasil Update Data!'];
        } else
            $response = ['status' => 'error', 'message' => 'Gagal Update Data!'];

        echo json_encode($response);
    }
}
