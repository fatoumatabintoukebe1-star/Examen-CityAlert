<?php
namespace App\Core;

class Router {
    private array $routes = [];

    public function add(string $method, string $path, string $controller,
                        string $action, array $roles = []): void {
        $this->routes[] = compact('method','path','controller','action','roles');
    }

    public function dispatch(string $method, string $uri): void {
        // Nettoyer l'URI
        $uri = parse_url($uri, PHP_URL_PATH);
        if (empty($uri)) $uri = '/';

        foreach ($this->routes as $route) {
            $pattern = '#^' . preg_replace('/{[^}]+}/', '([^/]+)', $route['path']) . '$#';
            if ($route['method'] === $method && preg_match($pattern, $uri, $m)) {
                array_shift($m);
                if (!empty($route['roles'])) {
                    Auth::require($route['roles']);
                }
                $ctrl = new $route['controller']();
                $ctrl->{$route['action']}(...$m);
                return;
            }
        }

        // Route non trouvée
        http_response_code(404);
        require dirname(__DIR__) . '/views/errors/404.php';
    }
}