pipeline {
    agent any

    stages {
        stage('Build') {
            steps {
                echo 'Iniciando Build...'
                sh 'composer install -d ./RENAPSys'
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
