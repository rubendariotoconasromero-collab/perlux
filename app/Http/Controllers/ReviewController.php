<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'product_id' => 'required|exists:products,ProductID',
                'rating' => 'required|integer|between:1,5',
                // 'comment' => 'required|string|max:1000',
                'title' => 'nullable|string|max:100',
                'age_range' => 'nullable|string|max:20',
                'size' => 'nullable|string|max:10'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos inválidos',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Verificar si el usuario ya calificó este producto
            $existingReview = Review::where('user_id', $request->user_id)
                                  ->where('product_id', $request->product_id)
                                  ->first();

            if ($existingReview) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya has calificado este producto anteriormente'
                ], 409);
            }

            // Crear la reseña
            $review = Review::create([
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
                'rating' => $request->rating,
                'comment' => $request->comment,
                'title' => $request->title,
                'age_range' => $request->age_range,
                'size' => $request->size,
            ]);

            // Cargar la relación con el usuario para devolver datos completos
            $review->load('user');

            return response()->json([
                'success' => true,
                'message' => 'Calificación registrada exitosamente',
                'review' => [
                    'id' => $review->id,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'title' => $review->title,
                    'created_at' => $review->created_at->toISOString(),
                    'user' => [
                        'name' => $review->user->name,
                        'last_name' => $review->user->last_name ?? '',
                    ]
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor',
                'error' => config('app.debug') ? $e->getMessage() : 'Error inesperado'
            ], 500);
        }
    }

    /**
     * Obtener reseñas de un producto específico
     */
    public function getProductReviews($productId)
    {
        try {
            $reviews = Review::with('user:id,name,last_name')
                           ->where('product_id', $productId)
                           ->orderBy('created_at', 'desc')
                           ->get();

            $formattedReviews = $reviews->map(function ($review) {
                return [
                    'id' => $review->id,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'title' => $review->title,
                    'created_at' => $review->created_at->toISOString(),
                    'user' => [
                        'name' => $review->user->name,
                        'last_name' => $review->user->last_name ?? '',
                    ]
                ];
            });

            // Calcular estadísticas
            $averageRating = $reviews->avg('rating');
            $totalReviews = $reviews->count();
            $ratingDistribution = $reviews->groupBy('rating')
                                        ->map(function ($group) use ($totalReviews) {
                                            return [
                                                'count' => $group->count(),
                                                'percentage' => $totalReviews > 0 ? round(($group->count() / $totalReviews) * 100, 1) : 0
                                            ];
                                        });

            return response()->json([
                'success' => true,
                'reviews' => $formattedReviews,
                'statistics' => [
                    'average_rating' => round($averageRating, 1),
                    'total_reviews' => $totalReviews,
                    'rating_distribution' => $ratingDistribution
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las reseñas',
                'error' => config('app.debug') ? $e->getMessage() : 'Error inesperado'
            ], 500);
        }
    }

    /**
     * Actualizar una reseña existente
     */
    public function update(Request $request, $id)
    {
        try {
            $review = Review::findOrFail($id);

            // Verificar que el usuario puede editar esta reseña
            if ($review->user_id !== $request->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes permisos para editar esta reseña'
                ], 403);
            }

            $validator = Validator::make($request->all(), [
                'rating' => 'sometimes|integer|between:1,5',
                'comment' => 'sometimes|string|max:1000',
                'title' => 'nullable|string|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos inválidos',
                    'errors' => $validator->errors()
                ], 422);
            }

            $review->update($request->only(['rating', 'comment', 'title']));
            $review->load('user');

            return response()->json([
                'success' => true,
                'message' => 'Reseña actualizada exitosamente',
                'review' => $review
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la reseña',
                'error' => config('app.debug') ? $e->getMessage() : 'Error inesperado'
            ], 500);
        }
    }

    /**
     * Eliminar una reseña
     */
    public function destroy($id, Request $request)
    {
        try {
            $review = Review::findOrFail($id);

            // Verificar permisos
            if ($review->user_id !== $request->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes permisos para eliminar esta reseña'
                ], 403);
            }

            $review->delete();

            return response()->json([
                'success' => true,
                'message' => 'Reseña eliminada exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la reseña',
                'error' => config('app.debug') ? $e->getMessage() : 'Error inesperado'
            ], 500);
        }
    }
}
