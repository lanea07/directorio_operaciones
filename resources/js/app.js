import './bootstrap';
import { data } from 'autoprefixer';
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();


function format(d) {
    // // `d` is the original data object for the row
    return '<div class="slider d-flex justify-content-center">' +
    '<div class="col-9">'+
        '<table class="table">' +
        '<tr>' +
            '<td><b>Dependencia</b></td> <td class="d-flex flex-wrap align-items-center text-secondary">' + (d.dependencia ? d.dependencia.nombre : '') + '</td>' +
            '<td><b>Area</b></td> <td class="d-flex flex-wrap align-items-center text-secondary">' + (d.area ? d.area.nombre : '') + '</td>' +
        '</tr>'+
        '<tr>' +
            '<td><b>Teléfono</b></td> <td class="d-flex flex-wrap align-items-center text-secondary">' + (d.dependencia ? d.dependencia.telefono : '') + '</td>' +
            '<td><b>Extensión</b></td> <td class="d-flex flex-wrap align-items-center text-secondary">' + (d.extension ? d.extension : '') + '</td>' +
        '</tr>' +
        '</table></div>' +
    '</div>';
}


$(document).ready(function(){

    var pusher = new Pusher('887fe1015230369e018c', {
        cluster: 'us2',
        encrypted: true
    });

    if ('permissions' in navigator) {
        Push.Permission.request(
            function () {
                console.log('Granted');
            },
            function () {
                console.log('Denied');
            }
        )
    }

    $('#directorio-table').on('requestChild.dt', function(e, row) {
        row.child(format(row.data())).show();
    });


    $('#directorio-table tbody').on('click', 'td.dt-control', function () {
        var tr = $(this).closest('tr');
        var row = $('#directorio-table').DataTable().row( tr );

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( template(row.data()) ).show();
            tr.addClass('shown');
        }
    });

    $("#liveToast").toast()

    Echo.channel('directorio')
    .listen('DirectorioUpdate', (e) => {
        console.log(e.updatedContact);
        $("#liveToast > div.toast-body").html('<a class="nav-link link-primary" href="https://directoriooperaciones.test/directorios/'+e.updatedContact.id+'">'+e.updatedContact.nombre+'</a>')
        $("#liveToast").toast('show');
        Push.create("Contacto del directorio actualizado!", {
            body: e.updatedContact.nombre,
            icon: 'https://ui-avatars.com/api/?name=' + e.updatedContact.nombre + '&size=64&format=png',
            timeout: 5000,
            onClick: function () {
                window.focus();
                window.open('https://directoriooperaciones.test/directorios/'+e.updatedContact.id);
                //this.close();
            }
        });
    })
    .listen('.DirectorioUpdate', (e)=>{
        console.log(e.updatedContact);
        $("#liveToast > div.toast-body").html('<a class="nav-link link-primary" href="https://directoriooperaciones.test/directorios/'+e.updatedContact.id+'">'+e.updatedContact.nombre+'</a>')
        $("#liveToast").toast('show');
        Push.create("Contacto del directorio actualizado!", {
            body: e.updatedContact.nombre,
            icon: 'https://ui-avatars.com/api/?name=' + e.updatedContact.nombre + '&size=64&format=png',
            timeout: 5000,
            onClick: function () {
                window.focus();
                window.open('https://directoriooperaciones.test/directorios/'+e.updatedContact.id);
                //this.close();
            }
        });
    });

    Echo.private('user.administrador')
    .listen('IssueCreated', (e) => {
        if (e.issueCreated > 0) {
            $("#notifyContainer > a").addClass('bg-warning');
            $("#notifyContainer > a > i").removeClass('fa-regular').addClass('fa-solid text-light');
            $("#notifyContainer > a > span").html(e.issueCreated)
        }
        else{
            $("#notifyContainer > a").removeClass('bg-warning');
            $("#notifyContainer > a > i").addClass('fa-solid text-light').removeClass('fa-regular');
            $("#notifyContainer > a > span").html('')
        }
        console.log(e);
    })
    .listen('.IssueCreated', (e) => {
        if (e.issueCreated > 0) {
            $("#notifyContainer > a").addClass('bg-warning');
            $("#notifyContainer > a > i").removeClass('fa-regular').addClass('fa-solid text-light');
            $("#notifyContainer > a > span").html(e.issueCreated)
        }
        else{
            $("#notifyContainer > a").removeClass('bg-warning');
            $("#notifyContainer > a > i").addClass('fa-solid text-light').removeClass('fa-regular');
            $("#notifyContainer > a > span").html('')
        }
        console.log(e);
    });

    $(".dataTable > thead").addClass('table-dark');

    $("#roles").selectize({
        plugins: ["remove_button"],
        delimiter: ",",
        persist: false,
        create: function (input) {
            return {
                value: input,
                text: input,
            };
        },
    });

    $(document).click(function (e) {
        var clickover = $(event.target);
        var _opened = $(".navbar-collapse").hasClass("navbar-collapse");
        if (_opened === true && !clickover.hasClass("navbar-toggle") && clickover.parents('.navbar-collapse').length == 0) {
            $(".navbar-collapse").collapse('hide');
        }
    });

    $("#issuedatatable-table_wrapper > div:nth-child(1) > div.toggler.m-2").html('<div id="togglerCheck" class="form-check form-switch"><input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="valid_0"><label class="form-check-label" for="flexSwitchCheckDefault">Incluir issues ya validados</label></div>')

    $("#togglerCheck").on('click', function() {
        if ($("#flexSwitchCheckDefault").is(':checked')) {
            $('#issuedatatable-table').DataTable().ajax.url("?valid_0=1").load();
        }
        else {
            $('#issuedatatable-table').DataTable().ajax.url("?valid_0=0").load();
        }
    });

    // $('#notifyContainer > a').on('click', ()=>{
    //     var data = new FormData()
    //     $.ajax({
    //         type: "post",
    //         url: "issues/ajax",
    //         data: data,
    //         dataType: "json",
    //         processData: false,
    //         contentType: false,
    //         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    //         success: function (response) {

    //         }
    //     });
    // });
});
