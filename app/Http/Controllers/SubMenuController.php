<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Cloudinary\Cloudinary;
use Cloudinary\Api\ApiUtils;
use App\Models\WeeklyItem;

class SubMenuController extends Controller
{
    /**
     * Get all submenus
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllSubmenus()
    {
        $submenus = DB::table('sub_menu')->get();

        // return response()->json([
        //     'success' => true,
        //     'data' => $submenus
        // ]);

        return response()->json($submenus);
    }

    /**
     * Get a specific submenu by ID
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSubmenu($id)
    {
        $submenu = DB::table('sub_menu')->where('id', $id)->first();

        if (!$submenu) {
            return response()->json([
                'success' => false,
                'message' => 'Submenu not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $submenu
        ]);
    }

    /**
     * Create a new submenu
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createSubmenu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|string|max:255',
            'gastronomy' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image_path' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $data['created_at'] = now(); // Add timestamp if your table has this column

        $id = DB::table('sub_menu')->insertGetId($data);

        return response()->json([
            'success' => true,
            'message' => 'Submenu created successfully',
            'data' => array_merge(['id' => $id], $data)
        ], 201);
    }

    /**
     * Update an existing submenu
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSubmenu(Request $request, $id)
    {
        $submenu = DB::table('sub_menu')->where('id', $id)->first();

        if (!$submenu) {
            return response()->json([
                'success' => false,
                'message' => 'Submenu not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'category' => 'sometimes|string|max:255',
            'gastronomy' => 'sometimes|string|max:255',
            'name' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric',
            'description' => 'nullable|string',
            'image_path' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        if (!empty($data)) {
            DB::table('sub_menu')->where('id', $id)->update($data);
        }

        $updatedSubmenu = DB::table('sub_menu')->where('id', $id)->first();

        return response()->json([
            'success' => true,
            'message' => 'Submenu updated successfully',
            'data' => $updatedSubmenu
        ]);
    }

    /**
     * Delete a submenu
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteSubmenu($id)
    {
        $submenu = DB::table('sub_menu')->where('id', $id)->first();

        if (!$submenu) {
            return response()->json([
                'success' => false,
                'message' => 'Submenu not found'
            ], 404);
        }

        DB::table('sub_menu')->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Submenu deleted successfully'
        ]);
    }

    public function generateSignature(Request $request)
    {
        $timestamp = time();

        // Manually generate the signature using Cloudinary's helper method
        $params_to_sign = [
            'timestamp' => $timestamp,
        ];

        // Generating the signature
        $signature = ApiUtils::signParameters($params_to_sign, "BzO-9abAfyiiib7aLj7KfiS4EVI");

        return response()->json([
            'signature' => $signature,
            'timestamp' => $timestamp,
            'api_key' => 743419794116277,
            'cloud_name' => "dcjfeebzi"
        ]);
    }

    /**
     * Liste tous les plats de la semaine (WeeklyItem)
     */
    public function getAllWeeklyItems()
    {
        $items = WeeklyItem::all();
        return response()->json($items);
    }

    /**
     * Affiche un plat de la semaine par ID
     */
    public function getWeeklyItem($id)
    {
        $item = WeeklyItem::find($id);
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Weekly item not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $item
        ]);
    }

    /**
     * Ajoute un plat au menu de la semaine
     */
    public function createWeeklyItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric',
            'categorie' => 'required|string|max:255',
            'vegetarien' => 'required|boolean',
            'epice' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        $item = WeeklyItem::create($validator->validated());
        return response()->json([
            'success' => true,
            'message' => 'Weekly item created successfully',
            'data' => $item
        ], 201);
    }

    /**
     * Met à jour un plat de la semaine
     */
    public function updateWeeklyItem(Request $request, $id)
    {
        $item = WeeklyItem::find($id);
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Weekly item not found'
            ], 404);
        }
        $validator = Validator::make($request->all(), [
            'code' => 'sometimes|string|max:255',
            'nom' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'sometimes|numeric',
            'categorie' => 'sometimes|string|max:255',
            'vegetarien' => 'sometimes|boolean',
            'epice' => 'sometimes|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        $item->update($validator->validated());
        return response()->json([
            'success' => true,
            'message' => 'Weekly item updated successfully',
            'data' => $item
        ]);
    }

    /**
     * Supprime un plat de la semaine
     */
    public function deleteWeeklyItem($id)
    {
        $item = WeeklyItem::find($id);
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Weekly item not found'
            ], 404);
        }
        $item->delete();
        return response()->json([
            'success' => true,
            'message' => 'Weekly item deleted successfully'
        ]);
    }

    /**
     * Supprime tous les plats de la semaine
     */
    public function deleteAllWeeklyItems()
    {
        try {
            WeeklyItem::truncate();
            return response()->json([
                'success' => true,
                'message' => 'All weekly items deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete all weekly items',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
