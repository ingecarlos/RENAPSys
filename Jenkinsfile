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
                
                echo 'servicio matrimonio'
                sh 'docker build -t servicio_matrimonio ./microservicios/servicio_matrimonio/'
                sh 'docker stop servicio_matrimonio-running || true && docker rm servicio_matrimonio-running || true'
                sh 'docker run --name servicio_matrimonio-running -p 9001:80 -d servicio_matrimonio'

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
