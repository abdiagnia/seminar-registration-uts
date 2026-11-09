<?php

class Router
{
    private array $routes = [];

    public function get(string $path, callable $callback): void
    {
        $this->add('GET', $path, $callback);
    }

    public function post(string $path, callable $callback): void
    {
        $this->add('POST', $path, $callback);
    }

    private function add(string $method, string $path, callable $callback): void
    {
        $this->routes[$method][$path] = $callback;
    }

    public function dispatch(string $method, string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');

        if ($base !== '' && $base !== '/' && str_starts_with($path, $base)) {
            $path = substr($path, strlen($base)) ?: '/';
        }

        $path = '/' . trim($path, '/');

        if ($path !== '/') {
            $path = rtrim($path, '/');
        }

        foreach ($this->routes[$method] ?? [] as $route => $callback) {
            $quoted = preg_quote($route, '#');
            $pattern = '#^' . str_replace('\\{id\\}', '(\\d+)', $quoted) . '$#';

            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches);
                $callback(...array_map('intval', $matches));
                return;
            }
        }

        http_response_code(404);
        echo '404 - Halaman tidak ditemukan';
    }
}
