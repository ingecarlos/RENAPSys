pipeline {
    agent any

    stages {
        stage('Build') {
            steps {
                echo 'Iniciando Build...'
                cp ./RENAPSys /var/www/html/RENAPSys/build

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
