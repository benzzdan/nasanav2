INSTRUCTIONS FOR DEPLOYMENT

1. git clone https://github.com/benzzdan/nasanav2.git
2. cd nasanav2
3. composer install
4. npm install
5. Create and edit .env: 
    setup your database name, username and password, you can copy sintax from .env.example.(need to have mysql running locally with database created)
6. php artisan migrate
7. php artisan key:generate
8. npm run dev
9. php artisan serve
10. Open up your browser and go to http://localhost:8000


INTRUCCIONES PARA EL DEPLOY LOCAL

1. git clone https://github.com/benzzdan/nasanav2.git
2. cd nasanav2
3. composer install
4. npm install
5. Crear y edita .env: 
    Escribe el nombre de la base de datos, usuario and password, se puede copiar del archivo .env.example.(para esto ya se tiene que tener localmente mysql instalado y poder crear una base de datos)
6. php artisan migrate
7. php artisan key:generate
8. npm run dev
9. php artisan serve
10. Abre tu navegador y la app estará corriendo en: http://localhost:8000


