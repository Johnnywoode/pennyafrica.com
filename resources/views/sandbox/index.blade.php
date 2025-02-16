@extends('layouts.sandbox')
@section('title', __('locale.titles.sandbox'))

@section('page_styles')
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- DataTables Buttons CSS -->
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" rel="stylesheet">

    <style>
        .sandbox-area {
            /* background: #222;*/
            height: auto;
            /* border: 5px solid; */
            /* border-image: linear-gradient(90deg, red, blue, green, yellow, purple) 1; */
            border-radius: 1rem;
            animation: animate-border 3s linear infinite;
            position: relative;
        }

        /* Glowing Blurred Effect */
        .sandbox-area::before {
            content: "";
            position: absolute;
            inset: -1rem;
            /* Extends slightly outside to keep smooth edges */
            border-radius: inherit;
            /* Ensures border follows same rounded shape */
            padding: 1rem;
            /* Simulates a border thickness */
            background: linear-gradient(90deg, red, blue, green, yellow, purple);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            filter: blur(10px);
            /* Adds glow effect */
            z-index: -1;
            animation: animate-border 3s linear infinite;
        }

        @keyframes animate-border {
            0% {
                border-image-source: linear-gradient(0deg, red, blue, green, yellow, purple);
                filter: hue-rotate(0deg);
            }

            100% {
                border-image-source: linear-gradient(360deg, red, blue, green, yellow, purple);
                filter: hue-rotate(360deg);
            }
        }
    </style>

@endsection

@section('content')
    <div class="container text-center">
        <div class="row g-4">
            <div class="col">
                <div class="card p-3">
                    <button id="transact-btn" class="btn btn-default btn-lg">Make Transaction</button>
                </div>
            </div>
            <div class="col">
                <div class="card p-3">Custom column padding</div>
            </div>
            <div class="col">
                <div class="card p-3">Custom column padding</div>
            </div>
            <div class="col">
                <div class="card p-3">Custom column padding</div>
            </div>
        </div>
    </div>

    <section class="row justify-content-center mt-4 bg-dark vh-100" style="">
        <div id="sandbox-area" class="col-11 col-md-8 col-lg-6 m-4 card sandbox-area">
            jsdhfsdfdss
        </div>

        <div class="row">
            <button class="btn btn-primary">Send</button>
        </div>
    </section>

@endsection


@section('page_script')

    <!-- jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>


    {{-- // Pusher  --}}
    <script src="https://js.pusher.com/8.2/pusher.min.js"></script>

    <script type="module">
        $(document).ready(function() {
            alert('jjjgbhh')

            window.Echo.channel('sandbox')
                .listen('.sent', (data) => {
                    console.log('Order status updated: ', data);
                    $("#sandbox-area").append("<p>" + data.message + "</p>");
                });
            // Enable debugging in console (optional)
            // Pusher.logToConsole = true;




            // Initialize Pusher
            // var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
            //     cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
            //     forceTLS: true
            // });

            // var channel = pusher.subscribe("messages");

            // channel.bind("message.sent", function(data) {
            //     $("#sandbox-area").append("<p>" + data.message + "</p>");
            // });

            $('#transact-btn').on('click', function() {

            });
        });
    </script>

@endsection
