pipeline {
    agent any

    stages {
        stage('Build') {
            steps {
                echo 'Iniciando Build...'
                echo 'creando contenedores'

                echo 'servicio defuncion'
                sh 'docker build -t servicio_defuncion ./microservicios/servicio_defuncion/'
                sh 'docker stop servicio_defuncion-running || true && docker rm servicio_defuncion-running || true'
                sh 'docker run --name servicio_defuncion-running -p 9002:80 -d servicio_defuncion'


                echo 'servicio divorcio'
                sh 'docker build -t servicio_divorcio ./microservicios/servicio_divorcio/'
                sh 'docker stop servicio_divorcio-running || true && docker rm servicio_divorcio-running || true'
                sh 'docker run --name servicio_divorcio-running -p 9003:80 -d servicio_divorcio'

                


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
