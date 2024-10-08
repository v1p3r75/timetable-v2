<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Google Tag Manager -->
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-9HTXFZ4EK6"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-9HTXFZ4EK6');
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Le projet LTN-Emploi est une application capable de gérer la planification des emplois du temps pour les administrateurs, élèves et professeurs.">
    <meta name="robots" content="index, follow">
    <meta name="author" content="LAWINGNI Abdoul Rachard">
    <meta name="theme-color" content="#3c91e6">
    <!-- Safari on iOS -->
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#3c91e6">
    <link rel="icon" href='/favicon.ico' type="image/x-icon">
    <link rel="manifest" href="/manifest.json">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    {{-- <link rel="stylesheet" href="http://localhost/bootstrap/dist/css/bootstrap.min.css"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.11.1/sweetalert2.all.min.js" integrity="sha512-awhfGDoHs6zOw2bGnlOX1tFMpn62CLz2skNks2+LiDdJIRi9rkXrf5A1fVb7VgFyymxFVp6EfFqOZFr8sqPu6g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
    {{-- @vite('resources/css/app.css') --}}
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/timetablejs.css">
    <script src="/js/timetable.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>

    <title>@yield('title', "Dashboard")</title>
</head>

<body>
    <div id="app">
        @include('Partials.sidebar')
        <section id="content">
            @include('Partials.header')
            <main>
                @yield('content')
            </main>
        </section>
        <footer>
            @include('Partials.footer')
        </footer>
    </div>
    {{-- @vite('resources/js/app.js') --}}
    <script src="/js/app.js"></script>
    @yield('scripts')
    <script>
        $(document).ready(function() {

            const testsGraph = {

                labels: ['Licence 1', 'Licence 2', 'Licence 3', 'Master I', 'Master II'],
                datasets: [{
                        label: 'Enseignants',
                        data: [3, 3, 3, 3, 3],
                        borderColor: '#18aefa', // Couleur de la ligne
                        backgroundColor: '#18aefa', // Couleur de fond
                        fill: false, // Pas de remplissage sous la ligne
                    },
                    {
                        label: 'élèves',
                        data: [5, 6, 7, 8, 9],
                        borderColor: '#3D5EE1', // Couleur de la ligne
                        backgroundColor: '#3D5EE1', // Couleur de fond
                        fill: false, // Pas de remplissage sous la ligne
                    },
                    {
                        label: 'Cours',
                        data: [2, 3, 4, 5, 10],
                        borderColor: '#2A3042', // Couleur de la ligne
                        backgroundColor: '#2A3042', // Couleur de fond
                        fill: false, // Pas de remplissage sous la ligne
                    }
                ]
            };

            // Configuration du graphique
            const options = {
                responsive: true,
                title: {
                    display: true,
                    text: "Comparaison du nombre d'enseignants, de cours et d'élèves"
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            };

            // Création du graphique
            const ctx = document.getElementById('graph-viewer')?.getContext('2d');
            const myChart = ctx && new Chart(ctx, {
                type: 'bar',
                data: testsGraph,
                options: options
            });

            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

        })

        const append_btns = document.querySelectorAll('.add-timetable');
        const del_btns = document.querySelectorAll('.delete-timetable');
        const tasks_to_delete = [];
        const new_tasks = [];

        const deleteLine = (e) => {
            e.preventDefault();

            const parent = e.currentTarget.parentElement.parentElement;

            const id = parent.querySelector('input[name="timetable_id[]"]')?.value;

            id != 'null' ? tasks_to_delete.push(id) : null;

            parent.outerHTML = ""
        }

        if (append_btns.length > 0) {
            append_btns.forEach((btn, i) => {
                btn.addEventListener('click', function(e) {

                    e.preventDefault();
                    const parent = btn.parentElement.parentElement;

                    const template = document.querySelector('#template')
                    const form = template.content.firstElementChild;
                    const clone = form.cloneNode(true);
                    const new_form = parent.appendChild(clone);

                    new_form.querySelector('input[name="day[]"]').value = btn.getAttribute('data-timetable-id');
                    new_form.querySelector('.delete-timetable')?.addEventListener('click', deleteLine)
                })
            })
        }

        if (del_btns.length > 0) {
            del_btns.forEach((btn, i) => {
                btn.addEventListener('click', deleteLine)
            })
        }

        const sendData = (e, edit) => {

            e.preventDefault();
            let route = '/admin/timetable/'

            const body = new FormData(document.querySelector('.timetable-form'));

            if (edit) {

                route += document.querySelector('input[name="id"]').value;
                body.delete('_method');
                body.append('_method', 'PATCH');
                body.append('tasks_to_delete[]', tasks_to_delete);
            }

            return fetch(route, {
                    method: 'POST',
                    body,
                    headers: {
                        'Accept': 'application/json'
                    }
                }).then(response => response.json())
                .then(response => {

                    if (response.success) {

                        new Promise((resolve, reject) => {
                            setTimeout(() => {
                                window.location.pathname = "/admin/timetable";
                                resolve(true);
                            }, 1500)
                        })

                        return toastr.success(response.message);
                    }

                    return toastr.error(response.message);
                })
                .catch(error => console.error(error));

        }

        const submit = document.querySelector('.timetable-form button[type="submit"]')

        if (submit) {
            submit.addEventListener('click', (e) => sendData(e, submit.getAttribute('data-form-type') === "edit"));
        }


        function printDiv() {

            const screen = window.open('', 'Emploi du temps', 'height=650,width=900,top=100,left=150');

            const link = document.createElement('link');
            link.rel = "stylesheet"
            link.href = "https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"

            const title = document.createElement('title');
            title.text = "Emploi du temps - LTN Emploi"

            screen.document.head.appendChild(link);
            screen.document.head.appendChild(title);

            const timetable = document.querySelector('.print').cloneNode(true);
            timetable.classList.add('container-fluid');
            timetable.removeChild(timetable.querySelector('.btn-print'))

            screen.document.body.appendChild(timetable);
            screen.document.body.style.cursor = 'wait';
            
            screen.focus();

            link.addEventListener('load', function() {
                
                screen.print();
                screen.close();

            })
            
        }

    </script>
</body>

</html>