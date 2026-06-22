import sys
from io import BytesIO
from pathlib import Path

from pypdf import PdfReader, PdfWriter
from reportlab.lib.utils import ImageReader
from reportlab.pdfgen import canvas


def stamp_first_page(source_file, qr_file, output_file):
    reader = PdfReader(source_file)
    writer = PdfWriter()

    qr_size = 35 * 72 / 25.4
    margin_right = 12 * 72 / 25.4
    margin_bottom = 12 * 72 / 25.4

    for index, page in enumerate(reader.pages):
        if index == 0:
            width = float(page.mediabox.width)
            height = float(page.mediabox.height)
            overlay_buffer = BytesIO()
            overlay = canvas.Canvas(overlay_buffer, pagesize=(width, height))
            overlay.drawImage(
                ImageReader(qr_file),
                width - qr_size - margin_right,
                margin_bottom,
                width=qr_size,
                height=qr_size,
                preserveAspectRatio=True,
                mask="auto",
            )
            overlay.save()
            overlay_buffer.seek(0)
            page.merge_page(PdfReader(overlay_buffer).pages[0])

        writer.add_page(page)

    Path(output_file).parent.mkdir(parents=True, exist_ok=True)
    with open(output_file, "wb") as output:
        writer.write(output)


if __name__ == "__main__":
    if len(sys.argv) != 4:
        print("Usage: doc_approval_pdf_stamp.py source.pdf qrcode.png output.pdf", file=sys.stderr)
        sys.exit(2)

    try:
        stamp_first_page(sys.argv[1], sys.argv[2], sys.argv[3])
    except Exception as exc:
        print(str(exc), file=sys.stderr)
        sys.exit(1)
