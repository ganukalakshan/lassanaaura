<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Exception;

class InstallerController extends Controller
{
    public function index()
    {
        // Check if already installed
        if ($this->isInstalled()) {
            return redirect('/')->with('error', 'Application is already installed.');
        }

        return view('installer.index');
    }

    public function install(Request $request)
    {
        $request->validate([
            'db_host' => 'required|string',
            'db_port' => 'required|numeric',
            'db_name' => 'required|string',
            'db_username' => 'required|string',
            'db_password' => 'nullable|string',
        ]);

        try {
            // Step 1: Test database connection
            $this->testDatabaseConnection($request);

            // Step 2: Update .env file
            $this->updateEnvFile($request);

            // Step 3: Clear config cache
            Artisan::call('config:clear');

            // Step 4: Run migrations
            Artisan::call('migrate', ['--force' => true]);

            // Step 5: Run seeders
            Artisan::call('db:seed', ['--force' => true]);

            // Step 6: Create installed flag
            $this->markAsInstalled();

            return response()->json([
                'success' => true,
                'message' => 'Installation completed successfully!',
                'redirect' => url('/')
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Installation failed: ' . $e->getMessage()
            ], 500);
        }
    }

    private function testDatabaseConnection(Request $request)
    {
        // First, connect without database to create it
        config([
            'database.connections.mysql.host' => $request->db_host,
            'database.connections.mysql.port' => $request->db_port,
            'database.connections.mysql.database' => null,
            'database.connections.mysql.username' => $request->db_username,
            'database.connections.mysql.password' => $request->db_password,
        ]);

        DB::purge('mysql');
        $pdo = DB::connection('mysql')->getPdo();
        
        // Create database if not exists
        $dbName = $request->db_name;
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        
        // Now reconnect with the database
        config(['database.connections.mysql.database' => $dbName]);
        DB::purge('mysql');
        DB::connection('mysql')->getPdo();
    }

    private function updateEnvFile(Request $request)
    {
        $envPath = base_path('.env');
        
        if (!File::exists($envPath)) {
            File::copy(base_path('.env.example'), $envPath);
        }

        $env = File::get($envPath);

        // Update or add DB configurations (remove # comments)
        $env = preg_replace('/DB_CONNECTION=.*/', 'DB_CONNECTION=mysql', $env);
        $env = preg_replace('/#?\s*DB_HOST=.*/', 'DB_HOST=' . $request->db_host, $env);
        $env = preg_replace('/#?\s*DB_PORT=.*/', 'DB_PORT=' . $request->db_port, $env);
        $env = preg_replace('/#?\s*DB_DATABASE=.*/', 'DB_DATABASE=' . $request->db_name, $env);
        $env = preg_replace('/#?\s*DB_USERNAME=.*/', 'DB_USERNAME=' . $request->db_username, $env);
        $env = preg_replace('/#?\s*DB_PASSWORD=.*/', 'DB_PASSWORD=' . $request->db_password, $env);

        File::put($envPath, $env);
    }

    private function isInstalled()
    {
        return File::exists(storage_path('installed'));
    }

    private function markAsInstalled()
    {
        File::put(storage_path('installed'), now()->toString());
    }
}
