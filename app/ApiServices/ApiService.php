<?php

namespace App\ApiServices;

use App\Models\Category;
use App\Models\Entity;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiService
{
    public function getEntries()
    {
        try {
            $response = Http::get('http://web.archive.org/web/20240403172734/https://api.publicapis.org/entries');

            if ($response->successful()) {
                $data = $response->json();

                foreach ($data['entries'] as $entry) {
                    // Filtrar solo las categorías "Animals" y "Security"
                    if (in_array($entry['Category'], ['Animals', 'Security'])) {
                        // Buscar la categoría si no existe la crea
                        $category = Category::firstOrCreate(
                            ['category' => $entry['Category']],
                            ['category' => $entry['Category']]
                        );

                        if($category) {
                            // Crear una nueva entidad con la categoría relacionada
                            Entity::create([
                                'api' => $entry['API'],
                                'description' => $entry['Description'],
                                'link' => $entry['Link'],
                                'category_id' => $category->id,
                            ]);
                        }
                    }
                }

                return ['success' => true, 'message' => 'Entidades creadas con exito.'];
            }


            return [
                'error' => true,
                'message' => 'Error al recuperar registros de la API.',
                'status' => $response->status()
            ];
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }
}
