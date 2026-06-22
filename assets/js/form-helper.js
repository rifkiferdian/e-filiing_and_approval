function toCurrency(el) {
  return el.value = formatRupiah(el.value);
}

function formatRupiah(a) {
  //a = Math.round(a);
  if (a !== null) {
    a = a.toString();
    var b = a.replace(/[^\d\,]/g, '');
    var dump = b.split(',');
    var c = '';
    var lengthchar = dump[0].length;
    var j = 0;
    for (var i = lengthchar; i > 0; i--) {
      j = j + 1;
      if (((j % 3) == 1) && (j != 1)) {
        c = dump[0].substr(i - 1, 1) + '.' + c;
      } else {
        c = dump[0].substr(i - 1, 1) + c;
      }
    }

    if (dump.length > 1) {
      if (dump[1].length > 0) {
        c += ',' + dump[1];
      } else {
        c += ',';
      }
    }
    return c;
  } else {
    return '0';
  }
}


function formatToNumber(currency) {
  var value = 0; var result = 0;
  if (currency !== null && currency !== undefined) {
    value = currency.replace(/\.+/g, '');
    result = value.replace(/,/g, '.');
  }
  return parseFloat(result);
}

function swalSaveSuccess() {
  Swal.fire({
    title: 'Great!',
    text: "The data have been save successfully!",
    icon: "success",
  })
}

function alertDeleteSuccess() {
  Swal.fire({
    title: 'Great!',
    text: "The data have been deleted!",
    icon: "success",
  })
}

function clearForm(el) {
  el.find("input").val("")
  el.find("textarea").val("")
  el.find("select").val("")
}

function setloading() {
  return `<div style="margin-top: auto; margin-bottom: auto" class="d-flex justify-content-center">
  <div class="spinner-grow text-primary" role="status">
    <span class="visually-hidden">Loading...</span>
  </div>
  <div class="spinner-grow text-secondary" role="status">
    <span class="visually-hidden">Loading...</span>
  </div>
  <div class="spinner-grow text-success" role="status">
    <span class="visually-hidden">Loading...</span>
  </div>
  <div class="spinner-grow text-danger" role="status">
    <span class="visually-hidden">Loading...</span>
  </div>
  <div class="spinner-grow text-warning" role="status">
    <span class="visually-hidden">Loading...</span>
  </div>
</div>`
}