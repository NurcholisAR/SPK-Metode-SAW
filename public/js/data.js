$(function () {
  $("#table_id").DataTable({
    retrieve: true,
    paging: true,
    lengthChange: true,
    searching: true,
    ordering: true,
    info: true,
    autoWidth: false,
    responsive: true,
    language: {
      url: "/js/bahasa.json",
    },
    pagingType: "full_numbers",
    pageLength: 5,
    lengthMenu: [5, 10, 15, 30],
    initComplete: function () {
      this.api()
        .columns([2, 3, 4])
        .every(function () {
          var column = this;
          var select = $('<select><option value=""></option></select>')
            .appendTo($(column.footer()).empty())
            .on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());

              column.search(val ? "^" + val + "$" : "", true, false).draw();
            });

          column
            .cells("", column[0])
            .render("display")
            .sort()
            .unique()
            .each(function (d, j) {
              var val = $("<div/>").html(d).text();
              select.append('<option value="' + val + '">' + val + "</option>");
            });
        });
    },
  });
  $("#table_id2").DataTable({
    paging: true,
    retrieve: true,
    lengthChange: true,
    searching: true,
    ordering: true,
    info: true,
    autoWidth: false,
    responsive: true,
    language: {
      url: "/js/bahasa.json",
    },
    pagingType: "full_numbers",
    pageLength: 5,
    lengthMenu: [5, 10, 15, 30],
    // ajax : 'Peringkat/list_peringkat',
    initComplete: function () {
      this.api()
        .columns([1, 2])
        .every(function () {
          var column = this;
          var select = $('<select><option value=""></option></select>')
            .appendTo($(column.footer()).empty())
            .on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());

              column.search(val ? "^" + val + "$" : "", true, false).draw();
            });

          column
            .cells("", column[0])
            .render("display")
            .sort()
            .unique()
            .each(function (d, j) {
              var val = $("<div/>").html(d).text();
              select.append('<option value="' + val + '">' + val + "</option>");
            });
        });
    },
  });
  $("#table_id3").DataTable({
    paging: true,
    retrieve: true,
    lengthChange: true,
    searching: true,
    ordering: true,
    info: true,
    autoWidth: false,
    responsive: true,
    language: {
      url: "/js/bahasa.json",
    },
    pagingType: "full_numbers",
    pageLength: 5,
    lengthMenu: [5, 10, 15, 30],
    initComplete: function () {
      this.api()
        .columns([2, 3])
        .every(function () {
          var column = this;
          var select = $('<select><option value=""></option></select>')
            .appendTo($(column.footer()).empty())
            .on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());

              column.search(val ? "^" + val + "$" : "", true, false).draw();
            });

          column
            .cells("", column[0])
            .render("display")
            .sort()
            .unique()
            .each(function (d, j) {
              var val = $("<div/>").html(d).text();
              select.append('<option value="' + val + '">' + val + "</option>");
            });
        });
    },
  });
  $("#table_alter").DataTable({
    paging: true,
    retrieve: true,
    lengthChange: true,
    searching: true,
    ordering: true,
    info: true,
    autoWidth: false,
    responsive: true,
    language: {
      url: "/js/bahasa.json",
    },
    pagingType: "full_numbers",
    pageLength: 5,
    lengthMenu: [5, 10, 15, 30],
    initComplete: function () {
      this.api()
        .columns([1, 2, 3])
        .every(function () {
          var column = this;
          var select = $('<select><option value=""></option></select>')
            .appendTo($(column.footer()).empty())
            .on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());

              column.search(val ? "^" + val + "$" : "", true, false).draw();
            });

          column
            .cells("", column[0])
            .render("display")
            .sort()
            .unique()
            .each(function (d, j) {
              var val = $("<div/>").html(d).text();
              select.append('<option value="' + val + '">' + val + "</option>");
            });
        });
    },
  });
});

$(function () {
  $('[data-toggle="tooltip"]').tooltip();
  // window.setTimeout(function () {
  //   $(".alert")
  //     .fadeOut(500, 0)
  //     .slideUp(500, function () {
  //       $(this).remove();
  //     });
  // }, 2000);
});
