<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Data Entry</h1>
      </div>
      <!-- <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Advanced Form</li>
        </ol>
      </div> -->
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- SELECT2 EXAMPLE -->

      <div class="col-md-12">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Person List
            </h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button> -->
            </div>
          </div>
          <!-- /.card-body -->

          <div class="card-body" style="overflow: auto;margin-right: 20px;white-space:nowrap;">
            <table id="tbl_person_covid19" style="width:100%;" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th width="1"><i class='fa fa-sitemap'></i></th>
                <th><i class='fa fa-user'></i> Name</th>
                <th width="1"><i class='fa fa-virus'></i> Status</th>
                <th width="1"><i class='fa fa-vial'></i> Test</th>
                <th width="1"><i class='fa fa-phone'></i></th>
                <th>Barangay</th>
                <th width="1"><i class='fa fa-venus-mars'></i></th>
                <th width="1">Age</th>
                <th width="1"><i class='fas fa-head-side-cough'></i></th>
                <th width="1"><i class='fas fa-sticky-note'></i></th>
                <th width="1">Level</th>
              </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
            <!-- /.card-body -->
          <!-- <div class="card-footer">
            <button type="submit" class="btn btn-info submitBtnLocal"><i class="fa fa-check"></i> Save Data</button>
          </div> -->
        </div>
      </div>

    </div>

  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->


<script type="text/javascript">
  var entryId=0;
  var thisData=0;
 

  $(function(){
    //addEntry();
    var tbl_person_covid19, tbl_personCovid19_data;
        tbl_person_covid19 = $("#tbl_person_covid19").DataTable({
                            "order": [[0, "desc" ]],
                            "columnDefs": [ {
                              // "targets"  : [0],
                              "orderable": false,
                            }],
                            "oLanguage": { "sSearch": "" },
                            language: {
                                searchPlaceholder: "Search...",
                            },
                            "paging": true,
                            "pageLength": 10,
                            "lengthChange": false,
                            "searching": true,
                            "ordering": true,
                            "info": true,
                            "autoWidth": false,
                            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                            ajax: {
                                url: "<?= base_url('useradmin/Dataentry2/getPersonCovid') ?>",
                                type: "POST",
                                data:
                                function(d) {
                                  return tbl_personCovid19_data;
                                }
                            }
                        });
    $("#tbl_person_covid19_filter").addClass("row");
    $("#tbl_person_covid19_filter label").css("width","100%").css("padding-right","15px");
    $("#tbl_person_covid19_filter .form-control-sm").css("width","100%");
    
    var save_primary = {
        clearForm: false,
        resetForm: false,
        beforeSubmit: function(e) {
            validate_form("form_save_dataPrimary");
            validatorC==0?e.preventDefault():"";
            $(".submitBtnPrimary").attr("disabled", true);
            $(".submitBtnPrimary").html("<span class=\"fa fa-spinner fa-pulse\"></span>");
        },
        success: function(data) {
            var d = JSON.parse(data);
            if(d.success == true) {
                successAlert();
                clear_form("form_save_dataPrimary");
            } else {
                failAlert();
            }
            $(".submitBtnPrimary").attr("disabled", false);
            $(".submitBtnPrimary").html("Save");
            $(".submitBtnPrimary").html("<span class=\"fa fa-check\"></span> Save Data");
            $('#tbl_person_covid19').DataTable().ajax.reload();
        }
    };
    $("#form_save_dataPrimary").ajaxForm(save_primary);

    var save_contact = {
        clearForm: false,
        resetForm: false,
        beforeSubmit: function(e) {
            validate_form("form_save_dataContact");
            validatorC==0?e.preventDefault():"";
            $(".submitBtnContact").attr("disabled", true);
            $(".submitBtnContact").html("<span class=\"fa fa-spinner fa-pulse\"></span>");
        },
        success: function(data) {
            var d = JSON.parse(data);
            if(d.success == true) {
                successAlert();
                clear_form("form_save_dataContact");

                $('.form_save_dataContact').slideUp();
                $('.form_save_dataPrimary').slideDown();
            } else {
                failAlert();
            }
            $(".submitBtnContact").attr("disabled", false);
            $(".submitBtnContact").html("Save");
            $(".submitBtnContact").html("<span class=\"fa fa-check\"></span> Save Data");
            $('#tbl_person_covid19').DataTable().ajax.reload();
        }
    };
    $("#form_save_dataContact").ajaxForm(save_contact);

    var save_status = {
        clearForm: false,
        resetForm: false,
        beforeSubmit: function(e) {
            validate_form("form_save_dataStatusHistory");
            validatorC==0?e.preventDefault():"";
            $(".submitBtnStatusHistory").attr("disabled", true);
            $(".submitBtnStatusHistory").html("<span class=\"fa fa-spinner fa-pulse\"></span>");
        },
        success: function(data) {
            var d = JSON.parse(data);
            if(d.success == true) {
                successAlert();
                clear_form("form_save_dataStatusHistory");
                $("#statusHistory").modal("hide");

                // $('.form_save_dataStatusHistory').slideUp();
                // $('.form_save_dataPrimary').slideDown();
            } else {
                failAlert();
            }
            $(".submitBtnStatusHistory").attr("disabled", false);
            $(".submitBtnStatusHistory").html("Save");
            $(".submitBtnStatusHistory").html("<span class=\"fa fa-check\"></span> Save Data");
            $('#tbl_person_covid19').DataTable().ajax.reload();
        }
    };
    $("#form_save_dataStatusHistory").ajaxForm(save_status);

    var save_test = {
        clearForm: false,
        resetForm: false,
        beforeSubmit: function(e) {
            validate_form("form_save_dataTestHistory");
            validatorC==0?e.preventDefault():"";
            $(".submitBtnTestHistory").attr("disabled", true);
            $(".submitBtnTestHistory").html("<span class=\"fa fa-spinner fa-pulse\"></span>");
        },
        success: function(data) {
            var d = JSON.parse(data);
            if(d.success == true) {
                successAlert();
                clear_form("form_save_dataTestHistory");
                $("#testHistory").modal("hide");

                // $('.form_save_dataTestHistory').slideUp();
                // $('.form_save_dataPrimary').slideDown();
            } else {
                failAlert();
            }
            $(".submitBtnTestHistory").attr("disabled", false);
            $(".submitBtnTestHistory").html("Save");
            $(".submitBtnTestHistory").html("<span class=\"fa fa-check\"></span> Save Data");
            $('#tbl_person_covid19').DataTable().ajax.reload();
        }
    };
    $("#form_save_dataTestHistory").ajaxForm(save_test);

    //covid19_status();
  });


function covid19_status(){
    $("#tbl_person_covid19_status").DataTable().destroy();
    $("#tbl_person_covid19_status tbody").empty();
    var tbl_person_covid19_status, tbl_personCovid19Status_data;
        tbl_person_covid19_status = $("#tbl_person_covid19_status").DataTable({
                            "columnDefs": [ {
                              "orderable": false,
                            }],
                            "oLanguage": { "sSearch": "" },
                            language: {
                                searchPlaceholder: "Search...",
                            },
                            "paging": false,
                            "pageLength": 10,
                            "lengthChange": false,
                            "searching": true,
                            "ordering": true,
                            "info": false,
                            "autoWidth": true,
                            ajax: {
                                url: "<?= base_url('useradmin/Dataentry2/getPersonCovidStatus') ?>",
                                type: "POST",
                                data:
                                function(d) {
                                  d.personId=$(".personStatusId").val();
                                  return tbl_personCovid19Status_data;
                                }
                            }
                        });
                        $('#tbl_person_covid19_status').on('draw.dt', function () {
                            $("#statusHistory").modal("show");
                        });
    $("#tbl_person_covid19_status_filter").addClass("row");
    $("#tbl_person_covid19_status_filter label").css("width","100%").css("padding-right","15px");
    $("#tbl_person_covid19_status_filter .form-control-sm").css("width","100%");
}

function covid19_test(){
    $("#tbl_person_covid19_test").DataTable().destroy();
    $("#tbl_person_covid19_test tbody").empty();
    var tbl_person_covid19_test, tbl_personCovid19test_data;
        tbl_person_covid19_test = $("#tbl_person_covid19_test").DataTable({
                            "columnDefs": [ {
                              "orderable": false,
                            }],
                            "oLanguage": { "sSearch": "" },
                            language: {
                                searchPlaceholder: "Search...",
                            },
                            "paging": false,
                            "pageLength": 10,
                            "lengthChange": false,
                            "searching": true,
                            "ordering": true,
                            "info": false,
                            "autoWidth": true,
                            ajax: {
                                url: "<?= base_url('useradmin/Dataentry2/getPersonCovidTest') ?>",
                                type: "POST",
                                data:
                                function(d) {
                                  d.personId=$(".personTestId").val();
                                  return tbl_personCovid19test_data;
                                }
                            }
                        });
                        $('#tbl_person_covid19_test').on('draw.dt', function () {
                            $("#testHistory").modal("show");
                        });
    $("#tbl_person_covid19_test_filter").addClass("row");
    $("#tbl_person_covid19_test_filter label").css("width","100%").css("padding-right","15px");
    $("#tbl_person_covid19_test_filter .form-control-sm").css("width","100%");
}

    function tfoot(){
      if($('#tbl_entry tr').length>6){
        $('#tbl_entry_foot').show();
      }else{
        $('#tbl_entry_foot').hide();
      }
    }

  //chart5();
  
  function myContact(a){
    $.post("<?= base_url() ?>" + "useradmin/Dataentry2/getContact",{value:a},
        function(a){
          var result = JSON.parse(a);
          var tmp = "";
          var tmp2 = "";
          var lvl = 0;
          var idArr = [];
          var maxArr = [];
          var cc = 0;
          var max = 0;

          for(var j=0;j<result["data2"].length;j++){
            if(tmp!=result["data2"][j][0]){
              lvl++;
              tmp2=result["data2"][j][0];
            }

            tmp = result["data2"][j][0];
            if(tmp2==tmp){
              idArr.push(result["data2"][j][0]);
              tmp2="";
            }
          }

          for(var j1=0;j1<idArr.length;j1++){
            var aa = idArr[j1];
            for(var j2=0;j2<result["data2"].length;j2++){
              if(Number(result["data2"][j2][0])==aa){
                cc++
              }
            }
            maxArr.push(cc);
            cc=0;
          }

          for(var j3=0;j3<maxArr.length;j3++){
            if(max>maxArr[j3]){
            }else{
              max=maxArr[j3];
            }
          }

          // console.log(maxArr)
          // console.log(max)
          // console.log(lvl)

          // var len = result["data1"].length;
          //console.log(lvl)
          var myWidth = lvl * 50;
          $("#myContact").css("width",myWidth+"%");
          thisData = max>0?1:0;


          Highcharts.chart('myContact', {
              chart: {
                  height: max<2?120:max*85,//max<2?100:(max<3?200:(max<6?500:(max<11?650:1000))),
                  inverted: false//len>2?false:true
              },

              title: {
                  text: 'CLOSE CONTACT GRAPH'
              },

              // accessibility: {
              //     point: {
              //         descriptionFormatter: function (point) {
              //             var nodeName = point.toNode.name,
              //                 nodeId = point.toNode.id,
              //                 nodeDesc = nodeName === nodeId ? nodeName : nodeName + ', ' + nodeId,
              //                 parentDesc = point.fromNode.id;
              //             return point.index + '. ' + nodeDesc + ', reports to ' + parentDesc + '.';
              //         }
              //     }
              // },
              plotOptions: {
                  series: {
                      enableMouseTracking: false
                  }
                  //series: {
                    //nodeWidth: '22%',
                    // nodeHeight: '30',
                  //}
              },

              series: [{
                  type: 'organization',
                  name: 'COVID19',
                  keys: ['from', 'to'],
                  // color: "#41c0a4",
                  data: result["data1"],
                  // levels: [{
                  //     level: 0,
                  //     color: 'silver',
                  //     dataLabels: {
                  //         color: 'black'
                  //     },
                  //     height: 20
                  // }
                  // , {
                  //     level: 1,
                  //     color: 'silver',
                  //     dataLabels: {
                  //         color: 'black'
                  //     },
                  //     height: 25
                  // }
                  // , {
                  //     level: 2,
                  //     color: '#980104'
                  // }, {
                  //     level: 4,
                  //     color: '#359154'
                  // }
                  // ],
                  // nodes: [{
                  //     id: '1'
                  // }, {
                  //     id: '2'
                  // }, {
                  //     id: '3'
                  // }],

              // series: [{
              //     type: 'organization',
              //     name: 'Highsoft',
              //     keys: ['from', 'to'],
              //     data: [
              //         ['Shareholders', 'Board'],
              //         ['Board', 'CEO'],
              //         ['CEO', 'CTO'],
              //         ['CEO', 'CPO'],
              //         ['CEO', 'CSO'],
              //         ['CEO', 'CMO'],
              //         ['CEO', 'HR'],
              //         ['CTO', 'Product'],
              //         ['CTO', 'Web'],
              //         ['CSO', 'Sales'],
              //         ['CMO', 'Market']
              //     ],
              //     levels: [{
              //         level: 0,
              //         color: 'silver',
              //         dataLabels: {
              //             color: 'black'
              //         },
              //         height: 25
              //     }, {
              //         level: 1,
              //         color: 'silver',
              //         dataLabels: {
              //             color: 'black'
              //         },
              //         height: 25
              //     }, {
              //         level: 2,
              //         color: '#980104'
              //     }, {
              //         level: 4,
              //         color: '#359154'
              //     }],
              //     nodes: [{
              //         id: 'Shareholders'
              //     }, {
              //         id: 'Board'
              //     }, {
              //         id: 'CEO',
              //         title: 'CEO',
              //         name: 'Grethe Hjetland',
              //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12132317/Grethe.jpg'
              //     }, {
              //         id: 'HR',
              //         title: 'HR/CFO',
              //         name: 'Anne Jorunn Fjærestad',
              //         color: '#007ad0',
              //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12132314/AnneJorunn.jpg',
              //         column: 3,
              //         offset: '75%'
              //     }, {
              //         id: 'CTO',
              //         title: 'CTO',
              //         name: 'Christer Vasseng',
              //         column: 4,
              //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12140620/Christer.jpg',
              //         layout: 'hanging'
              //     }, {
              //         id: 'CPO',
              //         title: 'CPO',
              //         name: 'Torstein Hønsi',
              //         column: 4,
              //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12131849/Torstein1.jpg'
              //     }, {
              //         id: 'CSO',
              //         title: 'CSO',
              //         name: 'Anita Nesse',
              //         column: 4,
              //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12132313/Anita.jpg',
              //         layout: 'hanging'
              //     }, {
              //         id: 'CMO',
              //         title: 'CMO',
              //         name: 'Vidar Brekke',
              //         column: 4,
              //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/13105551/Vidar.jpg',
              //         layout: 'hanging'
              //     }, {
              //         id: 'Product',
              //         name: 'Product developers'
              //     }, {
              //         id: 'Web',
              //         name: 'Web devs, sys admin'
              //     }, {
              //         id: 'Sales',
              //         name: 'Salessss team'
              //     }, {
              //         id: 'Market',
              //         name: 'Marketing team'
              //     }],
                  colorByPoint: false,
                  //color: '#007ad0',
                  // dataLabels: {
                  //     color: 'white'
                  // },
                  borderColor: 'white',
                  nodeWidth: '300',
                  // nodeHeight: '1%',
              }],
              // tooltip: {
              //     outside: true
              // },

              tooltip: {
                outside: true,
                formatter: function() {
                  return this.point.info;
                }
              },
              exporting: {
                  allowHTML: true,
                  sourceWidth: 800,
                  sourceHeight: 600
              }
          });
    }).done(function(){
      if(thisData==1){
        $("#graphPresentation").modal("show");
      }else{
        noData("No Data found!");
      }
    });
  }

  function addContact(a,b){
    $('html, body').animate({scrollTop : 0},800);
  
    $(".personRootId").val(a);
    $(".personRootName").val(b);
    $(".form_save_dataPrimary").slideUp();
    $(".form_save_dataContact").slideDown();

  }

  function updateStatus(a,b){
    $(".personStatusId").val(a);
    covid19_status();
  }

  function updateTest(a,b){
    $(".personTestId").val(a);
    $(".personTestName").val(b);
    covid19_test();
  }

  function chart5(a){
    $.post("<?= base_url() ?>" + "useradmin/Dataentry2/getContact",{value:a},
        function(a){
          var result = JSON.parse(a);
          thisData = result.length>0?1:0;

          Highcharts.chart('chart5', {
              chart: {
                  height: 600,
                  inverted: true
              },

              title: {
                  text: 'CLOSE CONTACT GRAPH'
              },

              accessibility: {
                  point: {
                      descriptionFormatter: function (point) {
                          var nodeName = point.toNode.name,
                              nodeId = point.toNode.id,
                              nodeDesc = nodeName === nodeId ? nodeName : nodeName + ', ' + nodeId,
                              parentDesc = point.fromNode.id;
                          return point.index + '. ' + nodeDesc + ', reports to ' + parentDesc + '.';
                      }
                  }
              },
              plotOptions: {
                  series: {
                      enableMouseTracking: false
                  }
              },

              series: [{
                  type: 'organization',
                  name: 'COVID19',
                  keys: ['from', 'to'],
                  // color: "#41c0a4",
                  data: result,
                  // levels: [{
                  //     level: 0,
                  //     color: 'silver',
                  //     dataLabels: {
                  //         color: 'black'
                  //     },
                  //     height: 20
                  // }
                  // , {
                  //     level: 1,
                  //     color: 'silver',
                  //     dataLabels: {
                  //         color: 'black'
                  //     },
                  //     height: 25
                  // }, {
                  //     level: 2,
                  //     color: '#980104'
                  // }, {
                  //     level: 4,
                  //     color: '#359154'
                  // }
                  //],
                  // nodes: [{
                  //     id: '1'
                  // }, {
                  //     id: '2'
                  // }, {
                  //     id: '3'
                  // }],

              // series: [{
              //     type: 'organization',
              //     name: 'Highsoft',
              //     keys: ['from', 'to'],
              //     data: [
              //         ['Shareholders', 'Board'],
              //         ['Board', 'CEO'],
              //         ['CEO', 'CTO'],
              //         ['CEO', 'CPO'],
              //         ['CEO', 'CSO'],
              //         ['CEO', 'CMO'],
              //         ['CEO', 'HR'],
              //         ['CTO', 'Product'],
              //         ['CTO', 'Web'],
              //         ['CSO', 'Sales'],
              //         ['CMO', 'Market']
              //     ],
              //     levels: [{
              //         level: 0,
              //         color: 'silver',
              //         dataLabels: {
              //             color: 'black'
              //         },
              //         height: 25
              //     }, {
              //         level: 1,
              //         color: 'silver',
              //         dataLabels: {
              //             color: 'black'
              //         },
              //         height: 25
              //     }, {
              //         level: 2,
              //         color: '#980104'
              //     }, {
              //         level: 4,
              //         color: '#359154'
              //     }],
              //     nodes: [{
              //         id: 'Shareholders'
              //     }, {
              //         id: 'Board'
              //     }, {
              //         id: 'CEO',
              //         title: 'CEO',
              //         name: 'Grethe Hjetland',
              //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12132317/Grethe.jpg'
              //     }, {
              //         id: 'HR',
              //         title: 'HR/CFO',
              //         name: 'Anne Jorunn Fjærestad',
              //         color: '#007ad0',
              //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12132314/AnneJorunn.jpg',
              //         column: 3,
              //         offset: '75%'
              //     }, {
              //         id: 'CTO',
              //         title: 'CTO',
              //         name: 'Christer Vasseng',
              //         column: 4,
              //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12140620/Christer.jpg',
              //         layout: 'hanging'
              //     }, {
              //         id: 'CPO',
              //         title: 'CPO',
              //         name: 'Torstein Hønsi',
              //         column: 4,
              //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12131849/Torstein1.jpg'
              //     }, {
              //         id: 'CSO',
              //         title: 'CSO',
              //         name: 'Anita Nesse',
              //         column: 4,
              //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12132313/Anita.jpg',
              //         layout: 'hanging'
              //     }, {
              //         id: 'CMO',
              //         title: 'CMO',
              //         name: 'Vidar Brekke',
              //         column: 4,
              //         image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/13105551/Vidar.jpg',
              //         layout: 'hanging'
              //     }, {
              //         id: 'Product',
              //         name: 'Product developers'
              //     }, {
              //         id: 'Web',
              //         name: 'Web devs, sys admin'
              //     }, {
              //         id: 'Sales',
              //         name: 'Salessss team'
              //     }, {
              //         id: 'Market',
              //         name: 'Marketing team'
              //     }],
                  colorByPoint: false,
                  color: '#007ad0',
                  dataLabels: {
                      color: 'white'
                  },
                  borderColor: 'white',
                  nodeWidth: 65
              }],
              tooltip: {
                  outside: true
              },
              exporting: {
                  allowHTML: true,
                  sourceWidth: 800,
                  sourceHeight: 600
              }
          });
    }).done(function(){
      if(thisData==1){
        $("#graphAnalytics").modal("show");
      }else{
        noData("No Data found!");
      }
    });
  }

  // $(".highcharts-root").css("font-family","arial");
  // $(".highcharts-data-labels").css("font-family","arial");
</script>