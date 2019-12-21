<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Informacion</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #BDBDBD;
                color: #1C1C1C;
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
                margin-bottom: 10px;
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
            <div class="title m-b-xs">
                    Nacimiento
            </div>               

                <form action="" method="" accept-charset="utf-8">
                  @csrf
                  <div class="contact-form">                  
                     <div class="form-group">                                                                   
                        
                        <div class="col-sm-10">          
                            <label class="col-6" for="apellidos">Apellidos:</label>
                            <input type="text" class="form-control" id="apellidos" placeholder="Apellidos" name="apellidos">
                            <span class="text-danger">{{ $errors->first('apellidos') }}</span>
                        </div>
                        
                        <div class="col-sm-10">          
                            <label class="col-6" for="nombres">Nombres:</label>
                            <input type="text" class="form-control" id="nombres" placeholder="Nombres" name="nombres">
                            <span class="text-danger">{{ $errors->first('nombres') }}</span>
                        </div>
                        
                        <div class="col-sm-10">          
                            <label class="col-8" for="fecha">Fecha de nacimiento:</label>
                            <input type="text" class="form-control" id="fecha" placeholder="Fecha nac" name="fecha">
                            <span class="text-danger">{{ $errors->first('fecha') }}</span>
                        </div>
                        
                        <div class="col-sm-10">          
                            <label class="col-6" for="depto">Departamento:</label>
                            <input type="text" class="form-control" id="depto" placeholder="Departamento" name="depto">
                            <span class="text-danger">{{ $errors->first('depto') }}</span>
                        </div>
                        
                        <div class="col-sm-10">          
                            <label class="col-6" for="municipio">Municipio:</label>
                            <input type="text" class="form-control" id="municipio" placeholder="Municipio" name="municipio">
                            <span class="text-danger">{{ $errors->first('municipio') }}</span>
                        </div>

                        <div class="col-sm-10">          
                            <label class="col-6" for="sexo">Sexo:</label>
                            <input type="text" class="form-control" id="sexo" placeholder="Sexo" name="sexo">
                            <span class="text-danger">{{ $errors->first('sexo') }}</span>
                        </div>

                        <div class="col-sm-10">          
                            <label class="col-6" for="estado">Estado Civil:</label>
                            <input type="text" class="form-control" id="estado" placeholder="Estado civil" name="estado">
                            <span class="text-danger">{{ $errors->first('estado') }}</span>
                        </div>
                     </div>                     
                     <br>
                     <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">                            
                            <button type="submit" class="btn btn-dark">Generar certificacion</button>
                        </div>
                     </div>                     

                  </div>
               </form>
                
            </div>
        </div>
    </body>
</html>