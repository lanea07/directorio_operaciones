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
        $("#liveToast").toast('show')
    })
    .listen('.DirectorioUpdate', (e)=>{
        console.log(e.updatedContact);
        $("#liveToast").toast('show')
    });

    Echo.private('user.administrador')
    .listen('IssueCreated', (e) => {
        $("#notifyContainer > a").addClass('bg-warning');
        $("#notifyContainer > a > i").removeClass('fa-regular').addClass('fa-solid text-light');
        $("#notifyContainer > a > span").html(e.issueCreated)
        console.log(e);
    })
    .listen('.IssueCreated', (e) => {
        $("#notifyContainer > a").addClass('bg-warning');
        $("#notifyContainer > a > i").removeClass('fa-regular').addClass('fa-solid text-light');
        $("#notifyContainer > a > span").html(e.issueCreated)
        console.log(e);
    });

    $(".dataTable > thead").addClass('table-dark');

    $("#notifyContainer > a").on('click', function(){

        new Notification('ToDo List');

        Push.create("Hello world!", {
            body: "How's it hangin'?",
            icon: '/icon.png',
            timeout: 4000,
            onClick: function () {
                window.focus();
                this.close();
            }
        });


        //--------Sección para notificaciones usando Pusher y Push.js
        if (Push.Permission.has()) {
            // Enable pusher logging - don't include this in production
            $("#btnRequest").addClass('d-none');
            Pusher.logToConsole = false;

            var pusher = new Pusher('887fe1015230369e018c', {
                cluster: 'us2',
                encrypted: true
            });

            var channel = pusher.subscribe('channel-Directorio-Operaciones');
            channel.bind('nuevo-Contacto', function (data) {
                // Push.create("Nuevo contacto", {
                //     body: data.nombre + '(' + data.usuarioRed + ')',
                //     icon: 'Resources/Images/user-cog-solid.png',
                //     timeout: 10000,
                //     onClick: function () {
                //         window.focus();
                //         this.close();
                //     }
                // });
                Push.create("Hello world!", {
                    body: "How's it hangin'?",
                    icon: '/icon.png',
                    timeout: 4000,
                    onClick: function () {
                        window.focus();
                        this.close();
                    }
                });
            });
        }

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
    });

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
