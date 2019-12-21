<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Defuncion</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #81F7D8;
                color: #2E2E2E;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
            .full-height {
                height: 100vh;
            }
            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }
            .position-ref {
                position: relative;
            }
            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }
            .content {
                text-align: center;
            }
            .title {
                font-size: 84px;
            }
            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>            
        <div class="flex-center position-ref full-height">         
            <div class="top-right links">             
                <a href="{{ url('/') }}">Regresar</a>                                                                
            </div>
            <div class="content">
            @if(Session::has('success'))
                <div class="alert alert-success">
                    {{Session::get('success')}}
                </div>
            @endif

                <div class="title m-b-md">
                    Defunción
                </div>

                <form action="{{ url('defuncion') }}" method="post" accept-charset="utf-8">
                  @csrf
                  <div class="contact-form">
                     <div class="form-group">                        
                        <div class="col-sm-10">          
                            <label class="control-label col-sm-2" for="fdpi">DPI:</label>
                            <input type="text" class="form-control" id="dpi" placeholder="Ingrese el DPI" name="dpi">
                            <span class="text-danger">{{ $errors->first('dpi') }}</span>
                        </div>
                     </div>

                     <div class="form-group">                        
                        <div class="col-sm-10">          
                            <label class="col-9" for="fechaf">Fecha de fallecimiento:</label>
                            <input type="text" class="form-control" id="fechaf" placeholder="Ingrese la fecha" name="fechaf">
                            <span class="text-danger">{{ $errors->first('fechaf') }}</span>
                        </div>
                     </div>
                     
                     <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <br>
                            <button type="submit" class="btn btn-dark">Guardar</button>
                        </div>
                     </div>                     

                  </div>
               </form>



                
            </div>
        </div>
    </body>
</html>