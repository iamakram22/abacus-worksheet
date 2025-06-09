$(document).ready(function () {
  // Automatically derive the base path from the current script's location
  const basePath = `${window.location.origin}${window.location.pathname.replace(
    /\/[^\/]+$/,
    ""
  )}`.replace(/\/+$/, "");
  const apiUrl = `${basePath}/api.php`;

  $("#worksheet_generator_form").validate();

  const submitBtn = $("#generate_worksheet");

  /*
   * Function to enable/disable submit button
   */
  function toggleSubmit() {
    if ($form.valid()) {
      submitBtn.prop("disabled", false);
    } else {
      submitBtn.prop("disabled", true);
    }
  }

  /**
   * Toggle VM options on type change
   */
  const worksheetType = $("#worksheet_type");

  worksheetType.on("change", function () {
    const subject = $(this).val();
    if (!subject) return;

    submitBtn.prop("disabled", true);

    $.ajax({
      url: apiUrl,
      method: "GET",
      dataType: "json",
      data: {
        action: "getClasses",
        subject: subject,
      },
      success: function (response) {
        const $class = $("#class");
        $class.empty().append('<option value="">Select Class</option>');

        // Correctly loop over `response`, not `classes`
        $.each(response, function (_, className) {
          $class.append(`<option value="${className}">${className}</option>`);
        });

        $class.prop("disabled", false);
        $("#topic")
          .empty()
          .append(
            '<option value="" selected disabled hidden>Select Topic</option>'
          )
          .prop("disabled", true);
        $("#fileList").empty();
      },
      error: function (xhr, status, error) {
        console.error("AJAX error:", error);
        alert("Failed to load classes");
      },
    });
  });

  $("#class").on("change", function () {
    const subject = worksheetType.val();
    const className = $(this).val();
    if (!className) return;

    submitBtn.prop("disabled", true);

    $.ajax({
      url: apiUrl,
      method: "GET",
      dataType: "json",
      data: {
        action: "getTopics",
        subject: subject,
        class: className,
      },
      success: function (response) {
        const $topic = $("#topic");
        $topic
          .empty()
          .append(
            '<option value="" selected disabled hidden>Select Topic</option>'
          );
        $.each(response, function (_, topicName) {
          $topic.append(`<option value="${topicName}">${topicName}</option>`);
        });
        $topic.prop("disabled", false);
        $("#fileList").empty();
      },
      error: function (xhr, status, error) {
        console.error("AJAX error:", error);
        alert("Failed to load classes");
      },
    });
  });

  $("#topic").on("change", function () {
    const subject = worksheetType.val();
    const className = $("#class").val();
    const topic = $(this).val();
    if (!topic) return;

    submitBtn.prop("disabled", true);

    $.ajax({
      url: apiUrl,
      method: "GET",
      dataType: "json",
      data: {
        action: "getFiles",
        subject: subject,
        class: className,
        topic: topic,
      },
      success: function (response) {
        const $list = $("#sheet");
        $list
          .empty()
          .append(
            '<option value="" selected disabled hidden>Select Sheet</option>'
          );
        $.each(response, function (_, fileName) {
          fileName = fileName.replace(".xlsx", "");
          $list.append(`<option value="${fileName}">${fileName}</option>`);
        });
        $list.prop("disabled", false);
      },
      error: function (xhr, status, error) {
        console.error("AJAX error:", error);
        alert("Failed to load classes");
      },
    });
  });

  $("#sheet").on("change", function () {
    submitBtn.prop("disabled", false);
  });
});
