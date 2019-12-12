pipeline {
    agent any

    stages {
        stage('Build') {
            steps {
                sh 'ls ./RENAPSys'
                sh 'cp -r ./RENAPSys /var/www/html/RENAPSys'
                echo 'Iniciando Build...'
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
