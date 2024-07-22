<?php include 'checklogin.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Tables</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include 'sideBar.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php include 'nav.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class=" m-0 font-weight-bold text-primary">ตารางจัดการกิจกรรม</h6>
                            <a href="addEvent.php" class="btn btn-success">
                                <i class="fa fa-plus"> </i> เพิ่มกิจกรรม
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0"
                                    id="myTable">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>ชื่อกิจกรรม</th>
                                            <th>วันที่และเวลา</th>
                                            <th>สถานที่</th>
                                            <th>รายละเอียด</th>
                                            <th>จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody class="" id="tableBody">
                                        <!-- ที่นี่จะเพิ่มข้อมูลในภายหลัง -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Content Wrapper -->
        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>


        <div id="modal-detail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-detail-label"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-detail-label">รายละเอียดกิจกรรม</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body row">
                        <div class="row">
                            <div id="showimg" class="col-md-6">
                                <img id="imageDisplay" width="100%" height="auto" src="" alt="">
                            </div>
                            <div id="showdetail" class="col-md-6 w-100" style="padding: 20px;">
                                <!-- รายละเอียดที่ต้องการแสดง -->
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            ปิด
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Page level custom scripts -->
        <!-- <script src="js/demo/datatables-demo.js"></script> -->
        <script>
            $(document).ready(function () {
                var data;

                function editEvent(id) {
                    // ตรวจสอบว่าข้อมูลไม่เป็น null และมีความยาวมากกว่า 0
                    window.location.href = `editEvent.php?id=${id}`;
                }

                $("#logoutLink").on("click", function (e) {
                    e.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: "./api/logout.php",
                        success: function (response) {

                            window.location.href = "login.php";

                        },
                    });
                });

                function showdetail(id) {
                    $.ajax({
                        url: `./api/getEvent.php?id=${id}`,
                        type: "GET",
                        success: function (response) {
                            let res = JSON.parse(response);

                            $("#showdetail").html(
                                `
                <p style="font-weight: bold;">รายละเอียดกิจกรรม : </p>
                <p style="text-indent: 2.5em;">${res.description}</p>

                     <div style="display:flex;">
                    <p style="font-weight: bold;">ผู้รับผิดชอบ : </p>
                    <p style="text-indent: 1em;"> ${res.personnel_fname + " " + res.personnel_lname // res.personnel_number
                                }</p>
                     </div>
                          <div style="display:flex;">
                   <p style="font-weight: bold;">ห้อง : </p>
                    <p style="text-indent: 1em;"> ${"-" || res.room_number + " - " + res.room_name
                                } </p>
                     </div>
                    <div style="display:flex;">
                   <p style="font-weight: bold;">หน่วยงานรองที่รับผิดชอบ : </p>
                    <p style="text-indent: 1em;"> ${res.branch_name}</p>
                     </div>
                    <div style="display:flex;">
                    <p style="font-weight: bold;">หน่วยงานหลักที่รับผิดชอบ : </p>
                    <p style="text-indent: 1em;"> ${res.faculty_name}</p>
                     </div>
                    `
                            );
                            $.ajax({
                                url: `./api/getImage.php?event_id=${id}`,
                                type: "GET",
                                xhrFields: {
                                    responseType: "blob", // Important for binary data
                                },
                                success: function (data) {
                                    var url = URL.createObjectURL(data);
                                    $("#imageDisplay").attr("src", url);
                                },
                                error: function () {
                                    alert("Failed to load image. Please check the image ID.");
                                },
                            });
                            $("#modal-detail").modal("show");
                        },
                        error: function (error) { },
                    });
                }

                function delEvent(id) {
                    Swal.fire({
                        title: "ยืนยันการลบรายการกิจกรรม",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "ยืนยัน",
                        cancelButtonText: "ยกเลิก",
                    })
                        .then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: "./api/deleteEvent.php",
                                    type: "POST",
                                    data: { event_id: id },
                                    success: function (response) {
                                        let res = JSON.parse(response);
                                        if (res.status == "success") {
                                            Swal.fire({
                                                title: "ลบสำเร็จ",
                                                icon: "success",
                                            }).then(() => {
                                                reloadData();
                                            });
                                        } else {
                                            Swal.fire({
                                                title: "เกิดข้อผิดพลาด",
                                                text: res.message,
                                                icon: "error",
                                            });
                                        }
                                    },
                                    error: function (error) {
                                        let res = JSON.parse(error.responseText);
                                        Swal.fire({
                                            title: "เกิดข้อผิดพลาด",
                                            text: res.message,
                                            icon: "error",
                                        });
                                    },
                                });
                            }
                        })
                        .catch((error) => { });
                }

                function loadDataFromApi() {
                    $.ajax({
                        url: "./api/getEvent.php",
                        type: "GET",
                        success: function (response) {
                            data = JSON.parse(response);

                            updateDataTable(data);
                        },
                        error: function (error) { },
                    });
                }

                function updateDataTable(data) {
                    var tableBody = $("#tableBody");
                    tableBody.empty();

                    $.each(data, function (index, item) {
                        var sequenceNumber = index + 1;
                        var editButton = $("<button>", {
                            text: "แก้ไข",
                            class: "btn btn-warning",
                            style: "margin-right:5px;",
                            click: function () {
                                editEvent(item.id);
                            },
                        });
                        var delButton = $("<button>", {
                            text: "ลบ",
                            class: "btn btn-danger",
                            style: "margin-left:5px;",
                            click: function () {
                                delEvent(item.id);
                            },
                        });
                        var detailButton = $("<button>", {
                            text: "ดู",
                            class: "btn btn-info text-center",
                            style: "margin-left:5px;",
                            click: function () {
                                showdetail(item.id);
                            },
                        });
                        delButton.append(
                            '<i style="margin-left:2px;" class="bi bi-trash"></i>'
                        );
                        editButton.append(
                            '<i style="margin-left:2px;" class="bi bi-pencil"></i>'
                        );
                        detailButton.append(
                            '<i style="margin-left:5px;" class="bi bi-search"></i>'
                        );
                        tableBody.append(
                            $("<tr>").append(
                                $("<td>").text(sequenceNumber),
                                $("<td>").text(item.name),
                                $("<td>").text(`${item.start_date} ถึง ${item.end_date}`),
                                $("<td>").text(item.location_name),
                                $("<td>").append(detailButton),
                                $("<td>").append(editButton, delButton)
                            )
                        );
                    });

                    // เปิดใช้ DataTables
                    $("#myTable").DataTable({
                        "sScrollX": "100%",
                        "sScrollXInner": "100%",
                        "bScrollCollapse": true,
                        language: {
                            url: "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Thai.json",
                        },
                    });
                }
                function reloadData() {
                    $("#myTable").DataTable().destroy();
                    loadDataFromApi();
                }

                loadDataFromApi();
            });
        </script>

</body>

</html>