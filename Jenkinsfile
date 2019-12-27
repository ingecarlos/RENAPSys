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
                


                echo 'Cliente Interno'
                sh 'docker build -t interno ./RENAPSys/'
                sh 'docker stop interno-running || true && docker rm interno-running || true'
                sh 'docker run --name interno-running -p 10000:80 -d interno'


                echo 'servicio licencia'
                sh 'docker build -t servicio_licencia ./microservicios/servicio_licencia/'
                sh 'docker stop servicio_licencia-running || true && docker rm servicio_licencia-running || true'
                sh 'docker run --name servicio_licencia-running -p 9005:80 -d servicio_licencia'




                echo 'servicio persona'
                sh 'docker build -t servicio_persona ./microservicios/servicio_persona/'
                sh 'docker stop servicio_persona-running || true && docker rm servicio_persona-running || true'
                sh 'docker run --name servicio_persona-running -p 9100:80 -d servicio_persona'
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
