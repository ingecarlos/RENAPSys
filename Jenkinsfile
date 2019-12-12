pipeline {
    agent any

    stages {
        stage('Build') {
            steps {
                echo 'Iniciando Build...'
                cd ./RENAPSys	
                composer install	
                mv .env.example .env	
                php artisan key:generate	
                php artisan serve --host 0.0.0.0 --port 9000
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
