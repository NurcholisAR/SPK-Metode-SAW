$(document).ready(function () {
  $("#form_tambah").validate({
    rules: {
      nama_alternatif: {
        required: true,
      },
      nama_kriteria: {
        required: true,
      },
      bobot_nilai: {
        required: true,
      },
    },
    messages: {
      nama_alternatif: {
        required: "Please enter a  address",
        nama_alternatif: "Please enter a vaild nama_alternatif address",
      },
      nama_kriteria: {
        required: "Please provide a nama_kriteria",
        minlength: "Your nama_kriteria_f must be at least 5 characters long",
      },
      bobot_nilai: {
        required: "Please provide a nama_kriteria_f",
      },
    },
    errorElement: "span",
    errorPlacement: function (error, element) {
      error.addClass("invalid-feedback");
      element.closest(".form-group").append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass("is-invalid");
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass("is-invalid");
    },
  });
});
