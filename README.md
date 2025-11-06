
- Requisitos: PHP 8.2+, Composer, Node, Herd)
- Instalacion:

cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install
npm run dev

- ACTUALIZAR .env, existe .env example para guiarse