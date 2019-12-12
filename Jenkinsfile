pipeline {
    agent any

    stages {
        stage('Build') {
            steps {
                echo 'Iniciando Build...'
                cd ./RENAPSys
                composer install

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
