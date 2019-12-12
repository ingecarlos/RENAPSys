pipeline {
    agent any

    stages {
        stage('Build') {
            steps {
                ls ./RENAPSys
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
