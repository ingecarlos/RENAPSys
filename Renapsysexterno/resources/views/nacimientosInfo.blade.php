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
        <div class="flex-center ">
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
                    Nacimientos
            </div>
            
                <form action="" method="" accept-charset="utf-8">
                
                  <div class="contact-form">
                     <div class="form-group">

                        <div class="col-sm-14">                       
                            @foreach($respuesta as $key => $value)
    			                @if (!is_array($value))
                                    @if ($key=='noacta')
                                        <label class="col-6">Número de acta: {{ $value }}</label>
                                    @endif    
                                    @if ($key=='apellidos')
                                        <label class="col-6">Apellidos: {{ $value }}</label>
                                    @endif    
                                    @if ($key=='nombre')
                                        <label class="col-6">Nombres: {{ $value }}</label>
                                    @endif 			                
                                    @if ($key=='dpipadre')
                                        <label class="col-6">DPI del padre: {{ $value }}</label>
                                    @endif 
                                    @if ($key=='nombrepadre')
                                        <label class="col-6">Nombre del padre: {{ $value }}</label>
                                    @endif 
                                    @if ($key=='apellidopadre')
                                        <label class="col-6">Apellidos del padre: {{ $value }}</label>
                                    @endif 
                                    @if ($key=='dpimadre')
                                        <label class="col-6">DPI de la madre: {{ $value }}</label>
                                    @endif 
                                    @if ($key=='apellidomadre')
                                        <label class="col-6">Apellidos de la madre: {{ $value }}</label>
                                    @endif 
                                    @if ($key=='nombremadre')
                                        <label class="col-6">Nombres de la madre: {{ $value }}</label>
                                    @endif 
                                    @if ($key=='fechanac')
                                        <label class="col-6">Fecha de nacimiento: {{ $value }}</label>
                                    @endif 
                                    @if ($key=='departamento')
                                        <label class="col-6">Departamento: {{ $value }}</label>
                                    @endif 
                                    @if ($key=='municipio')
                                        <label class="col-6">Municipio: {{ $value }}</label>
                                    @endif 
                                    @if ($key=='genero')
                                        @if ($value=='m'|| $value=='M'|| $value=='h'|| $value=='H' )
                                            <label class="col-6">Sexo: Masculino</label>
                                        @endif
                                        @if ($value=='f'|| $value=='F' )
                                            <label class="col-6">Sexo: Femenino</label>
                                        @endif                                    
                                    @endif 
    	  	                    @else
            			            @foreach ($value as $key => $valu)
                                        @if ($key=='noacta')
                                            <label class="col-6">Número de acta: {{ $valu }}</label>
                                        @endif   
                                        @if ($key=='apellidos')
                                            <label class="col-6">Apellidos: {{ $valu }}</label>
                                        @endif    
                                        @if ($key=='nombre')
                                            <label class="col-6">Nombres: {{ $valu }}</label>
                                        @endif 			                
                                        @if ($key=='dpipadre')
                                            <label class="col-6">DPI del padre: {{ $valu }}</label>
                                        @endif 
                                        @if ($key=='nombrepadre')
                                            <label class="col-6">Nombre del padre: {{ $valu }}</label>
                                        @endif 
                                        @if ($key=='apellidopadre')
                                            <label class="col-6">Apellidos del padre: {{ $valu }}</label>
                                        @endif 
                                        @if ($key=='dpimadre')
                                            <label class="col-6">DPI de la madre: {{ $valu }}</label>
                                        @endif 
                                        @if ($key=='apellidomadre')
                                            <label class="col-6">Apellidos de la madre: {{ $valu }}</label>
                                        @endif 
                                        @if ($key=='nombremadre')
                                            <label class="col-6">Nombres de la madre: {{ $valu }}</label>
                                        @endif 
                                        @if ($key=='fechanac')
                                            <label class="col-6">Fecha de nacimiento: {{ $valu }}</label>
                                        @endif 
                                        @if ($key=='departamento')
                                            <label class="col-6">Departamento: {{ $valu }}</label>
                                        @endif 
                                        @if ($key=='municipio')
                                            <label class="col-6">Municipio: {{ $valu }}</label>
                                        @endif 
                                        @if ($key=='genero')
                                            @if ($valu=='m'|| $valu=='M'|| $valu=='h'|| $valu=='H' )
                                                <label class="col-6">Sexo: Masculino</label>
                                            @endif
                                            @if ($valu=='f'|| $valu=='F' )
                                                <label class="col-6">Sexo: Femenino</label>
                                            @endif  
                                        @endif          			                
            		                @endforeach
                                    <br><hr style="width:95%; border-color:black;"><br>
            	                @endif
                               
                            @endforeach 
                        </div>
                        <br>
                     <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-dark">Certificado</button>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
        </div>
    </body>
</html>
