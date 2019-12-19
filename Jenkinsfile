pipeline {
    agent any

    stages {
        stage('Build') {
            steps {
                echo 'Iniciando Build...'
                sh 'composer install -d ./RENAPSys'
                sh 'php ./RENAPSys/artisan key:generate'

                sh 'sudo docker build -t servicio_prueba ./microservicios/servicio_prueba/'
                sh 'sudo docker run --rm --name servicio_prueba-running servicio_prueba -port 20000:20000'

            }
        }
        stage('Test') {
            steps {
                echo 'Realizando pruebas...'
                sh './RENAPSys/vendor/bin/phpunit ./RENAPSys/tests/Feature'
            }
        }
        stage('Deploy') {
            steps {
                echo 'Despliegue...'
                sh 'rm -r /var/www/html/RENAPSys'
                sh 'cp -r ./RENAPSys /var/www/html/'
                sh 'if [ $(lsof -t -i:9000) != "" ]; then kill $(lsof -t -i:9000); else echo "vacio"; fi'
                sh 'JENKINS_NODE_COOKIE=dontKillMe nohup php /var/www/html/RENAPSys/artisan serve --host 0.0.0.0 --port 9000 &'
            }
        }
    }
}
