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
                            <h6 class=" m-0 font-weight-bold text-primary">ตารางจัดการหน่วยงานหลัก</h6>
                            <button data-toggle="modal" data-target="#create-modal" class="btn btn-success">
                                <i class="fa fa-plus"> </i> เพิ่มหน่วยงานหลัก
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0"
                                    id="myTable">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>ชื่อ</th>
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
        <div class="modal fade" id="create-modal" tabindex="-1" role="dialog" aria-labelledby="create-modalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="create-modalLabel">
                            เพิ่มหน่วยงานหลัก
                        </h3>
                    </div>
                    <div class="modal-body">
                        <label for="">ชื่อ : </label>
                        <input placeholder="ชื่อหน่วยงานหลัก" id="create-name" class="form-control" type="text" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            ยกเลิก
                        </button>
                        <button id="confirm-create" type="button" class="btn btn-primary">
                            เพิ่ม
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="create-modalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="create-modalLabel">
                            แก้ไขหน่วยงานหลัก
                        </h3>
                    </div>
                    <div class="modal-body">
                        <input style="display: none" type="text" name="" id="id" />
                        <label for="">ชื่อ : </label>
                        <input id="edit-name" class="form-control" type="text" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            ยกเลิก
                        </button>
                        <button id="confirm-edit" type="button" class="btn btn-primary">
                            บันทึก
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
                $("#logoutLink").on("click", function (e) {
                    e.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: "./api/logout.php",
                        success: function (response) {
                            var data = JSON.parse(response);
                            Swal.fire({
                                title: "แจ้งเตือน",
                                text: data.message,
                                icon: "success",
                            }).then(() => {
                                // Optionally, redirect to the login page or home page after logout
                                window.location.href = "login.php";
                            });
                        },
                    });
                });
                var data;
                $("#confirm-create").click((e) => {
                    let dataCreate = {
                        name: $("#create-name").val(),
                    };

                    $.ajax({
                        url: "./api/addFaculty.php",
                        type: "POST",
                        data: dataCreate,
                        success: function (response) {
                            let res = JSON.parse(response);
                            if (res.status == "success") {
                                Swal.fire({
                                    title: "เพิ่มสำเร็จ",
                                    icon: "success",
                                }).then(() => {
                                    $("#create-name").val("");
                                    $("#create-modal").modal("hide");
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
                });

                $("#confirm-edit").click((e) => {
                    let dataUpdate = {
                        id: $("#id").val(),
                        name: $("#edit-name").val(),
                    };

                    Swal.fire({
                        title: "ยืนยันการแก้ไขหน่วยงานหลัก",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "ยืนยัน",
                        cancelButtonText: "ยกเลิก",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "./api/editFaculty.php",
                                type: "POST",
                                data: dataUpdate,
                                success: function (response) {
                                    let res = JSON.parse(response);
                                    if (res.status == "success") {
                                        Swal.fire({
                                            title: "แก้ไขสำเร็จ",
                                            icon: "success",
                                        }).then(() => {
                                            $("#edit-modal").modal("hide");
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
                    });
                });

                function editFaculty(id) {
                    $.ajax({
                        url: `./api/getFaculty.php?id=${id}`,
                        type: "GET",
                        success: function (response) {
                            let res = JSON.parse(response);
                            if (res.status == "error") {
                                Swal.fire({
                                    title: "เกิดข้อผิดพลาด",
                                    text: res.message,
                                    icon: "error",
                                });
                            } else {
                                $("#edit-name").val(res.name);
                                $("#id").val(res.id);
                                $("#edit-modal").modal("show");
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

                function delFaculty(id) {
                    Swal.fire({
                        title: "ยืนยันการลบหน่วยงานหลัก",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "ยืนยัน",
                        cancelButtonText: "ยกเลิก",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "./api/deleteFaculty.php",
                                type: "POST",
                                data: { id: id },
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
                    });
                    /*
                          $.ajax({
                            url: 'URL_API_ของคุณ',
                            type: 'DELETE',
                            data: { id: selectedData.id },
                            success: function(response) {
                              console.log('ลบข้อมูลสำเร็จ', response);
                        
                              / 
                              loadDataFromApi();
                            },
                            error: function(error) {
                          
                            }
                          });
                          */
                }

                function loadDataFromApi() {
                    $.ajax({
                        url: "./api/getFaculty.php",
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
                        index = index + 1;
                        var editButton = $("<button>", {
                            text: "แก้ไข",
                            class: "btn btn-warning",
                            style: "margin-right:5px;",
                            click: function () {
                                editFaculty(item.id);
                            },
                        });
                        var delButton = $("<button>", {
                            text: "ลบ",
                            class: "btn btn-danger",
                            style: "margin-left:5px;",
                            click: function () {
                                delFaculty(item.id);
                            },
                        });

                        delButton.append(
                            '<i style="margin-left:2px;" class="bi bi-trash"></i>'
                        );
                        editButton.append(
                            '<i style="margin-left:2px;" class="bi bi-pencil"></i>'
                        );
                        tableBody.append(
                            $("<tr>").append(
                                $("<td>").text(index),
                                $("<td>").text(item.name),
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