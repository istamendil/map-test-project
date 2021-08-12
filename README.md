# Map Test Project
Project on Symfony with example of using Yandex Maps. After registration user can create application with description and coordinates. On main page all coordinates are shown on a map.
Since application list can be pretty large map points are loaded with ObjectManager on frontend (Yandex API). It loads data from static /data.json file. Symfony on backend generates it with GenerateApplicationListFileCommand.

## Used
1. Symfony Skeleton Pack (Console, Doctrine ORM, Security, Twig)
2. Yarn + Webpack
3. Frontend stuff: jQuery, Bootstrap, SASS
4. Yandex JS Map API

## What can be improved:
1. Guess coordinates by string address so user will be able to enter it into apply form.
2. Add Loading notification due data.json can be pretty large.
3. Add fixture with test application list.
4. Fix some minor code problems.
