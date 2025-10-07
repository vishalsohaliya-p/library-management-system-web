# library-management-system-web
composer require symfony/http-client symfony/serializer

composer require symfony/validator

composer require symfony/twig-bundle

composer require symfony/asset

composer require symfony/security-bundle

composer require symfony/form


Kubernetes

docker build -t library-frontend:latest .
kind load docker-image library-frontend:latest --name lms-cluster

kubectl apply -f k8s/frontend-deployment.yaml
kubectl apply -f k8s/frontend-service.yaml

kubectl get pods -n library-api
kubectl get svc -n library-api

kubectl port-forward svc/library-frontend 30002:8001 -n library-api &



docker build -t library-frontend:v2 .
kind load docker-image library-frontend:v2 --name lms-cluster

kubectl apply -f k8s/frontend-deployment.yaml
kubectl apply -f k8s/frontend-service.yaml

kubectl get pods -n library-api
kubectl get svc -n library-api

