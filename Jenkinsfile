pipeline {
    agent any

    stages {
        stage('Build') {
            steps {
                echo 'Iniciando Build...'
                echo 'creando contenedores'

                echo 'servicio nacimiento'
                sh 'docker build -t servicio_nacimiento ./microservicios/servicio_nacimiento/'
                sh 'docker stop servicio_nacimiento-running || true && docker rm servicio_nacimiento-running || true'
                sh 'docker run --name servicio_nacimiento-running -p 9000:80 -d servicio_nacimiento'

                echo 'servicio matrimonio'
                sh 'docker build -t servicio_matrimonio ./microservicios/servicio_matrimonio/'
                sh 'docker stop servicio_matrimonio-running || true && docker rm servicio_matrimonio-running || true'
                sh 'docker run --name servicio_matrimonio-running -p 9001:80 -d servicio_matrimonio'


                echo 'servicio defuncion'
                sh 'docker build -t servicio_defuncion ./microservicios/servicio_defuncion/'
                sh 'docker stop servicio_defuncion-running || true && docker rm servicio_defuncion-running || true'
                sh 'docker run --name servicio_defuncion-running -p 9002:80 -d servicio_defuncion'


                echo 'servicio divorcio'
                sh 'docker build -t servicio_divorcio ./microservicios/servicio_divorcio/'
                sh 'docker stop servicio_divorcio-running || true && docker rm servicio_divorcio-running || true'
                sh 'docker run --name servicio_divorcio-running -p 9003:80 -d servicio_divorcio'

                echo 'servicio DPI'
                sh 'docker build -t servicio_dpi ./microservicios/servicio_persona/'
                sh 'docker stop servicio_dpi-running || true && docker rm servicio_dpi-running || true'
                sh 'docker run --name servicio_dpi-running -p 9004:80 -d servicio_dpi'

                echo 'servicio licencia'
                sh 'docker build -t servicio_licencia ./microservicios/servicio_licencia/'
                sh 'docker stop servicio_licencia-running || true && docker rm servicio_licencia-running || true'
                sh 'docker run --name servicio_licencia-running -p 9005:80 -d servicio_licencia'


                echo 'servicio esb'
                sh 'docker build -t servicio_esb ./microservicios/servicio_esb/'
                sh 'docker stop servicio_esb-running || true && docker rm servicio_esb-running || true'
                sh 'docker run --name servicio_esb-running -p 10000:80 -d servicio_esb'

                echo 'servicio cliente'
                sh 'docker build -t servicio_cliente ./microservicios/servicio_cliente'
                sh 'docker stop servicio_cliente-running || true && docker rm servicio_cliente-running || true'
                sh 'docker run --name servicio_cliente-running -p 9006:80 -d servicio_cliente'

                echo 'Cliente Interno'
                sh 'docker build -t interno ./RENAPSys/'
                sh 'docker stop interno-running || true && docker rm interno-running || true'
                sh 'docker run --name interno-running -p 11000:80 -d interno'

                echo 'Cliente externo'
                sh 'docker build -t externo ./RENAPSysE/'
                sh 'docker stop externo-running || true && docker rm externo-running || true'
                sh 'docker run --name externo-running -p 11001:80 -d externo'


            }
        }
        stage('Test') {
            steps {
                echo 'Realizando pruebas...'
                
            }
        }
        stage('Deploy') {
            steps {
                echo 'Despliegue...'

            }
        }
    }
}
