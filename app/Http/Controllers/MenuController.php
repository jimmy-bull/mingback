<?php
// app/Http/Controllers/Api/MenuController.php
// declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menus;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index(): JsonResponse
    {
        $menus = Menus::all();
        return response()->json($menus);
    }

    // public function ad_menu(Request $request)
    // {

    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'gastronomy' => 'required|string|max:255',
    //         'price_per_person' => 'required|numeric',
    //         'min_people' => 'required|integer',
    //         'description' => 'nullable|string',
    //     ]);

    //     $menu = Menu::create($validated);
    //     return response()->json($menu, 201);
    // }



    /**
     * Create a new menu via GET parameters.
     *
     * Route:
     * Route::get(
     *     'add_menu/{name}/{gastronomy}/{price_per_person}/{min_people}/{description?}',
     *     [MenuController::class, 'addMenu']
     * );
     *
     * @param  string      $name
     * @param  string      $gastronomy
     * @param  float       $price_per_person
     * @param  int         $min_people
     * @param  string|null $description
     *
     */
    public function add_menu(
        string $name,
        string $gastronomy,
        $price_per_person,
        $min_people,
        $description = null
    ) {
        // Assemble data array
        $data = [
            'name' => $name,
            'gastronomy' => $gastronomy,
            'price_per_person' => $price_per_person,
            'min_people' => $min_people,
            'description' => $description,
        ];

        // Validate parameters
        $validator = Validator::make($data, [
            'name'              => 'required|string|max:255',
            'gastronomy'        => 'required|string|max:255',
            'price_per_person'  => 'required|numeric',
            'min_people'        => 'required|integer',
            'description'       => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        // Create and return new menu
        // $menu = Menu::create($validator->validated());
        // Insert data into the 'menus' table
        DB::table('menu')->insertGetId(
            array_merge(
                $validator->validated(),
                ['created_at' => now()]
            )
        );

        return "added";
    }

    public function show(Menus $menu): JsonResponse
    {
        return response()->json($menu);
    }

    public function getMenuById(int $id): JsonResponse
    {
        $menu = Menus::find($id);
        if (!$menu) {
            return response()->json(['message' => 'Menu not found'], 404);
        }
        return response()->json($menu);
    }

    public function destroy(Request $request)
    {
        Menus::where("id", "=", $request->id)->delete();
        return "deleted";
    }
}
