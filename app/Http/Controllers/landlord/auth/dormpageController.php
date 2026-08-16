<?php

namespace App\Http\Controllers\landlord\auth;

use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\landlord\landlordModel;
use App\Models\landlord\dormaminitiesModel;
use App\Models\landlord\aminitiesModel;
use App\Models\landlord\dormModel;
use App\Models\landlord\dormimagesModel;
use App\Models\landlord\dormrulesModel;
use App\Models\landlord\rulesModel;
use App\Models\notificationModel;

class dormpageController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Dorm Management Page
    |--------------------------------------------------------------------------
    */
   public function DormManagement($landlordId)
{
    try {

        // Get landlord ID from session
        $sessionLandlordId = session('landlord_id');

        // Check if logged in
        if (!$sessionLandlordId) {
            return redirect()
                ->route('loginLandlord')
                ->with('error', 'Please log in as a landlord.');
        }

        // Prevent landlord from accessing another landlord's page
        if ((string) $landlordId !== (string) $sessionLandlordId) {
            return redirect()
                ->route('loginLandlord')
                ->with('error', 'Unauthorized access.');
        }

        // Find landlord
        $landlord = landlordModel::where('landlordID', $landlordId)->first();

        if (!$landlord) {
            return redirect()
                ->route('loginLandlord')
                ->with('error', 'Landlord not found.');
        }

        // DO NOT query notifications here
        // because notifications table does not exist yet.

        return view('landlord.auth.DormManagement', [
            'title' => 'Landlord - Dorm Management',
            'headerName' => 'Dorm Management',
            'color' => 'primary',
            'landlord' => $landlord,
            'landlord_id' => $landlordId,
        ]);

    } catch (\Exception $e) {

        // Log actual error
        Log::error('Dorm Management Error', [
            'landlord_id' => $landlordId,
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);

        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong. Check logs for details.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

    /*
    |--------------------------------------------------------------------------
    | Get Landlord Verification Status
    |--------------------------------------------------------------------------
    */
    public function getlandlordVerifiedStatus()
    {
        try {

            $landlordId = session('landlord_id');

            if (!$landlordId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized action.'
                ], 403);
            }

            $landlord = landlordModel::where(
                'landlordID',
                $landlordId
            )->first();

            if (!$landlord) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Landlord not found.'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'isVerified' => $landlord->isVerified,
            ]);

        } catch (\Throwable $e) {

            Log::error('getlandlordVerifiedStatus error', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Search Dorms
    |--------------------------------------------------------------------------
    */
    public function searchDorms(Request $request)
    {
        $landlordId = session('landlord_id');

        if (!$landlordId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized action. Please log in as a landlord.'
            ], 403);
        }

        $searchTerm = strtolower(
            $request->input('search', '')
        );

        $dorms = dormModel::with('images')
            ->where('fklandlordID', $landlordId)
            ->when(!empty($searchTerm), function ($query) use ($searchTerm) {
                $query->whereRaw(
                    'LOWER(dormName) LIKE ?',
                    ["%{$searchTerm}%"]
                );
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return response()->json([
            'status' => 'success',
            'message' => $dorms->isEmpty()
                ? 'No dormitories found matching your search criteria.'
                : null,
            'dorms' => $dorms
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Filter Locations
    |--------------------------------------------------------------------------
    */
    public function filterLocations(Request $request)
    {
        $landlordId = session('landlord_id');

        if (!$landlordId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized action. Please log in as a landlord.'
            ], 403);
        }

        $location = strtolower(
            $request->input('location', '')
        );

        $dorms = dormModel::with('images')
            ->where('fklandlordID', $landlordId)
            ->when(
                $location !== 'all' && !empty($location),
                function ($query) use ($location) {

                    $query->whereRaw(
                        "LOWER(address) REGEXP ?",
                        ['[[:<:]]' . $location . '[[:>:]]']
                    );
                }
            )
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return response()->json([
            'status' => 'success',
            'message' => $dorms->isEmpty()
                ? 'No dormitories found matching your search criteria.'
                : null,
            'dorms' => $dorms
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Filter Availability
    |--------------------------------------------------------------------------
    */
    public function filteredAvailability(Request $request)
    {
        $landlordId = session('landlord_id');

        if (!$landlordId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized action.'
            ], 403);
        }

        $availability = strtolower(
            $request->input('availability', '')
        );

        $dorms = dormModel::with('images')
            ->where('fklandlordID', $landlordId)
            ->when(
                !empty($availability) && $availability !== 'all',
                function ($query) use ($availability) {

                    $query->whereRaw(
                        'LOWER(availability) = ?',
                        [$availability]
                    );
                }
            )
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return response()->json([
            'status' => 'success',
            'message' => $dorms->isEmpty()
                ? 'No dormitories found matching your search criteria.'
                : null,
            'dorms' => $dorms
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Validate Dorm Input
    |--------------------------------------------------------------------------
    */
    public function inputFieldDorm(Request $request)
    {
        try {

            $request->validate([
                'dorm_name' => 'required|string|max:255|unique:dorms,dormName',
                'address' => 'required|string|max:255',
                'description' => 'required|string',
                'total_rooms' => 'required|integer|min:1',
                'contact_email' => 'required|email|max:255',
                'contact_phone' => 'required|string|max:11|min:11',
                'availability' => 'required|string',
                'occupancy_type' => 'required|string',
                'building_type' => 'required|string',
                'gcashNumber' => 'required|string|regex:/^09[0-9]{9}$/',
            ], [

                'dorm_name.required' => 'Please enter the dormitory name.',
                'dorm_name.unique' => 'This dormitory name is already taken.',
                'dorm_name.max' => 'The dormitory name must not exceed 255 characters.',

                'availability.required' => 'Please enter the Availability.',

                'occupancy_type.required' =>
                    'Please enter the Occupancy type name.',

                'building_type.required' =>
                    'Please enter the Building type.',

                'gcashNumber.required' =>
                    'Please enter your GCash number.',

                'gcashNumber.regex' =>
                    'Invalid GCash number format. Must be 11 digits starting with 09.',

                'address.required' =>
                    'Please enter the address.',

                'address.max' =>
                    'The address must not exceed 255 characters.',

                'total_rooms.required' =>
                    'Please enter the total number of rooms.',

                'total_rooms.integer' =>
                    'Total rooms must be a number.',

                'total_rooms.min' =>
                    'There must be at least 1 room.',

                'contact_email.required' =>
                    'Please enter a contact email.',

                'contact_email.email' =>
                    'Please enter a valid contact email.',

                'contact_email.max' =>
                    'The contact email must not exceed 255 characters.',

                'contact_phone.required' =>
                    'Please enter a contact phone number.',

                'contact_phone.max' =>
                    'The contact phone number must not exceed 11 characters.',
            ]);

            return response()->json([
                'status' => 'success'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->errors(),
            ], 422);

        } catch (\Throwable $e) {

            Log::error('inputFieldDorm error', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Upload Main Image Validation
    |--------------------------------------------------------------------------
    */
    public function uploadmainImage(Request $request)
    {
        try {

            $request->validate([
                'roomImage1File' =>
                    'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ], [

                'roomImage1File.required' =>
                    'Please upload an image of the room.',

                'roomImage1File.image' =>
                    'The uploaded file must be an image.',

                'roomImage1File.mimes' =>
                    'Only jpeg, png, jpg, gif, or svg formats are allowed.',

                'roomImage1File.max' =>
                    'The image must not exceed 2MB in size.',
            ]);

            return response()->json([
                'status' => 'success'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Throwable $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Upload Secondary Image Validation
    |--------------------------------------------------------------------------
    */
    public function uploadsecondaryImage(Request $request)
    {
        try {

            $request->validate([
                'roomImage2File' =>
                    'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            return response()->json([
                'status' => 'success'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Throwable $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Add Dorm
    |--------------------------------------------------------------------------
    */
    public function AddDorm(Request $request)
    {
        $landlordId = session('landlord_id');

        if (!$landlordId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized action. Please log in as a landlord.'
            ], 403);
        }

        try {

            $validated = $request->validate([
                'dorm_name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'description' => 'nullable|string',
                'total_rooms' => 'required|integer|min:1',
                'contact_email' => 'required|email|max:255',
                'contact_phone' => 'required|string|max:11',
                'rules' => 'nullable|string',

                'roomImage1File' =>
                    'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

                'roomImage2File' =>
                    'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

                'roomImage3File' =>
                    'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

                'availability' => 'required|string',
                'occupancy_type' => 'required|string',
                'building_type' => 'required|string',
                'gcashNumber' => 'required|string',
            ]);

            /*
            |--------------------------------------------------------------------------
            | Generate Dorm ID
            |--------------------------------------------------------------------------
            */
            do {
                $randomDormId = rand(1000, 9999);
            } while (
                dormModel::where(
                    'dormID',
                    $randomDormId
                )->exists()
            );

            /*
            |--------------------------------------------------------------------------
            | Create Dorm
            |--------------------------------------------------------------------------
            */
            $dorm = new dormModel();

            $dorm->dormID = $randomDormId;
            $dorm->dormName = $validated['dorm_name'];
            $dorm->address = $validated['address'];
            $dorm->fklandlordID = $landlordId;
            $dorm->latitude = $validated['latitude'];
            $dorm->longitude = $validated['longitude'];
            $dorm->description = $validated['description'] ?? null;
            $dorm->totalRooms = $validated['total_rooms'];
            $dorm->gcashNumber = $validated['gcashNumber'];
            $dorm->contactEmail = $validated['contact_email'];
            $dorm->contactPhone = $validated['contact_phone'];
            $dorm->availability = $validated['availability'];
            $dorm->occupancyType = $validated['occupancy_type'];
            $dorm->buildingType = $validated['building_type'];

            $dorm->save();

            /*
            |--------------------------------------------------------------------------
            | Upload Images
            |--------------------------------------------------------------------------
            */
            $mainImageUrl = null;
            $secondImageUrl = null;
            $thirdImageUrl = null;

            if ($request->hasFile('roomImage1File')) {

                $image1 = $request->file('roomImage1File');

                $image1Name =
                    time() . '_1.' .
                    $image1->getClientOriginalExtension();

                $image1->storeAs(
                    'public/uploads/roomImages',
                    $image1Name
                );

                $mainImageUrl =
                    asset(
                        'storage/uploads/roomImages/' .
                        $image1Name
                    );
            }

            if ($request->hasFile('roomImage2File')) {

                $image2 = $request->file('roomImage2File');

                $image2Name =
                    time() . '_2.' .
                    $image2->getClientOriginalExtension();

                $image2->storeAs(
                    'public/uploads/roomImages',
                    $image2Name
                );

                $secondImageUrl =
                    asset(
                        'storage/uploads/roomImages/' .
                        $image2Name
                    );
            }

            if ($request->hasFile('roomImage3File')) {

                $image3 = $request->file('roomImage3File');

                $image3Name =
                    time() . '_3.' .
                    $image3->getClientOriginalExtension();

                $image3->storeAs(
                    'public/uploads/roomImages',
                    $image3Name
                );

                $thirdImageUrl =
                    asset(
                        'storage/uploads/roomImages/' .
                        $image3Name
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | Save Images
            |--------------------------------------------------------------------------
            */
            $dormImage = new dormimagesModel();

            $dormImage->fkdormID = $dorm->dormID;
            $dormImage->mainImage = $mainImageUrl;
            $dormImage->secondaryImage = $secondImageUrl;
            $dormImage->thirdImage = $thirdImageUrl;

            $dormImage->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Dorm added successfully!',
                'dormId' => $dorm->dormID,
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Throwable $e) {

            Log::error('AddDorm error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'landlord_id' => $landlordId,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error adding dorm.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Update Dorm
    |--------------------------------------------------------------------------
    */
    public function UpdateDorm(Request $request, $id)
    {
        try {

            $validated = $request->validate([

                'dormName' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('dorms', 'dormName')
                        ->ignore($id, 'dormID'),
                ],

                'address' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'totalRooms' => 'required|integer|min:1',
                'contactEmail' => 'required|email|max:255',
                'contactPhone' =>
                    'required|string|min:11|max:11|regex:/^\+?[0-9]{7,11}$/',

                'availability' => 'required|string',
                'occupancyType' => 'required|string',
                'gcashNumber' => 'required|string|regex:/^09[0-9]{9}$/',
                'buildingType' => 'required|string',
            ]);

            $landlordId = session('landlord_id');

            if (!$landlordId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized action.'
                ], 403);
            }

            $dorm = dormModel::where('dormID', $id)
                ->where('fklandlordID', $landlordId)
                ->first();

            if (!$dorm) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Dorm not found.'
                ], 404);
            }

            $dorm->dormName = $validated['dormName'];
            $dorm->address = $validated['address'];
            $dorm->latitude = $validated['latitude'];
            $dorm->longitude = $validated['longitude'];
            $dorm->description = $validated['description'];
            $dorm->totalRooms = $validated['totalRooms'];
            $dorm->gcashNumber = $validated['gcashNumber'];
            $dorm->contactEmail = $validated['contactEmail'];
            $dorm->contactPhone = $validated['contactPhone'];
            $dorm->availability = $validated['availability'];
            $dorm->occupancyType = $validated['occupancyType'];
            $dorm->buildingType = $validated['buildingType'];

            $dorm->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Dorm updated successfully!',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Throwable $e) {

            Log::error('UpdateDorm error', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error updating dorm.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Dorm
    |--------------------------------------------------------------------------
    */
    public function DeleteDorm($id)
    {
        try {

            $landlordId = session('landlord_id');

            if (!$landlordId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized action.'
                ], 403);
            }

            $dorm = dormModel::where('dormID', $id)
                ->where('fklandlordID', $landlordId)
                ->first();

            if (!$dorm) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Dorm not found.'
                ], 404);
            }

            $dorm->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Dorm deleted successfully!',
            ]);

        } catch (\Throwable $e) {

            Log::error('DeleteDorm error', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | View Dorm
    |--------------------------------------------------------------------------
    */
    public function ViewDorm($id)
    {
        try {

            $landlordId = session('landlord_id');

            if (!$landlordId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized action.'
                ], 403);
            }

            $dorm = dormModel::with([
                'amenities',
                'images',
                'rulesAndPolicy',
                'reviews.tenant'
            ])
            ->where('dormID', $id)
            ->where('fklandlordID', $landlordId)
            ->first();

            if (!$dorm) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Dorm not found.'
                ], 404);
            }

            $totalReviews = $dorm->reviews->count();

            $reviews = $dorm->reviews->map(function ($review) {

                $stars = str_repeat(
                    '⭐',
                    (int) $review->rating
                );

                return [
                    'id' => $review->id,
                    'rating' => $review->rating,
                    'stars' => $stars,
                    'comment' => $review->review,

                    'created_at' =>
                        $review->created_at
                            ? $review->created_at
                                ->format('F d, Y h:i A')
                            : null,

                    'firstname' =>
                        $review->tenant->firstname ?? 'Anonymous',

                    'lastname' =>
                        $review->tenant->lastname ?? '',

                    'profileImage' =>
                        $review->tenant->pictureID ?? null,
                ];
            });

            return response()->json([
                'status' => 'success',
                'dorm' => $dorm,
                'total_reviews' => $totalReviews,
                'reviews' => $reviews,
            ]);

        } catch (\Throwable $e) {

            Log::error('ViewDorm error', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'dorm_id' => $id,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | List Dorms
    |--------------------------------------------------------------------------
    */
    public function ListDorms()
    {
        try {

            $landlordId = session('landlord_id');

            if (!$landlordId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized action.'
                ], 403);
            }

            $dorms = dormModel::where(
                'fklandlordID',
                $landlordId
            )->paginate(2);

            return response()->json([
                'status' => 'success',
                'dorms' => $dorms,
                'landlord_id' => $landlordId,
            ]);

        } catch (\Throwable $e) {

            Log::error('ListDorms error', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Add Amenities
    |--------------------------------------------------------------------------
    */
    public function AddAmenities(Request $request)
    {
        $landlordId = session('landlord_id');

        if (!$landlordId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized action.'
            ], 403);
        }

        $validated = $request->validate([
            'amenities' => 'required|string|max:255',
            'dorm_id' => 'required|integer',
        ]);

        try {

            $amenityName = trim(
                $validated['amenities']
            );

            $dormId = $validated['dorm_id'];

            /*
            |--------------------------------------------------------------------------
            | Check Dorm Ownership
            |--------------------------------------------------------------------------
            */
            $ownsDorm = dormModel::where(
                'dormID',
                $dormId
            )
            ->where(
                'fklandlordID',
                $landlordId
            )
            ->exists();

            if (!$ownsDorm) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized dormitory.'
                ], 403);
            }

            /*
            |--------------------------------------------------------------------------
            | Find/Create Amenity
            |--------------------------------------------------------------------------
            */
            $amenity = aminitiesModel::firstOrCreate([
                'aminityName' => $amenityName
            ]);

            /*
            |--------------------------------------------------------------------------
            | Check Existing Link
            |--------------------------------------------------------------------------
            */
            $exists = dormaminitiesModel::where(
                'fkdormID',
                $dormId
            )
            ->where(
                'fkaminityID',
                $amenity->id
            )
            ->exists();

            if ($exists) {
                return response()->json([
                    'status' => 'error',
                    'message' =>
                        'This amenity already exists for this dormitory.'
                ], 400);
            }

            dormaminitiesModel::create([
                'fkdormID' => $dormId,
                'fkaminityID' => $amenity->id,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Amenity added successfully!',
            ]);

        } catch (\Throwable $e) {

            Log::error('AddAmenities error', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error adding amenities.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Amenities
    |--------------------------------------------------------------------------
    */
    public function DeleteAmenities($pivotId)
    {
        $landlordId = session('landlord_id');

        if (!$landlordId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. Please log in.'
            ], 403);
        }

        $pivot = dormaminitiesModel::find($pivotId);

        if (!$pivot) {
            return response()->json([
                'status' => 'error',
                'message' => 'Amenity link not found.'
            ], 404);
        }

        $ownsDorm = dormModel::where(
            'dormID',
            $pivot->fkdormID
        )
        ->where(
            'fklandlordID',
            $landlordId
        )
        ->exists();

        if (!$ownsDorm) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized to delete this amenity.'
            ], 403);
        }

        $pivot->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Amenity removed from dorm.'
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Add Rules & Policy
    |--------------------------------------------------------------------------
    */
    public function addRulesAndPolicy(Request $request)
    {
        $landlordId = session('landlord_id');

        if (!$landlordId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized action.'
            ], 403);
        }

        $validated = $request->validate([
            'rules' => 'required|string|max:255',
            'dorm_id' => 'required|integer',
        ]);

        try {

            $rules = trim(
                $validated['rules']
            );

            $dormId = $validated['dorm_id'];

            /*
            |--------------------------------------------------------------------------
            | Check Dorm Ownership
            |--------------------------------------------------------------------------
            */
            $ownsDorm = dormModel::where(
                'dormID',
                $dormId
            )
            ->where(
                'fklandlordID',
                $landlordId
            )
            ->exists();

            if (!$ownsDorm) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized dormitory.'
                ], 403);
            }

            /*
            |--------------------------------------------------------------------------
            | Find/Create Rule
            |--------------------------------------------------------------------------
            */
            $existingRule = rulesModel::firstOrCreate([
                'rulesName' => $rules
            ]);

            /*
            |--------------------------------------------------------------------------
            | Check Existing Link
            |--------------------------------------------------------------------------
            */
            $alreadyLinked = dormrulesModel::where(
                'fkdormID',
                $dormId
            )
            ->where(
                'fkruleID',
                $existingRule->id
            )
            ->exists();

            if ($alreadyLinked) {
                return response()->json([
                    'status' => 'error',
                    'message' =>
                        'This rule is already linked to this dormitory.'
                ], 400);
            }

            dormrulesModel::create([
                'fkdormID' => $dormId,
                'fkruleID' => $existingRule->id,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Rules added successfully!',
            ]);

        } catch (\Throwable $e) {

            Log::error('addRulesAndPolicy error', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error adding rules.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Rules & Policies
    |--------------------------------------------------------------------------
    */
    public function deleteRulesAndPolicies($pivotId)
    {
        $landlordId = session('landlord_id');

        if (!$landlordId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. Please log in.'
            ], 403);
        }

        $pivot = dormrulesModel::find($pivotId);

        if (!$pivot) {
            return response()->json([
                'status' => 'error',
                'message' => 'Rule link not found.'
            ], 404);
        }

        $ownsDorm = dormModel::where(
            'dormID',
            $pivot->fkdormID
        )
        ->where(
            'fklandlordID',
            $landlordId
        )
        ->exists();

        if (!$ownsDorm) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized to delete this rule.'
            ], 403);
        }

        $pivot->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Rule removed from dorm.'
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Dorm Images
    |--------------------------------------------------------------------------
    */
    public function dormImages(Request $request)
    {
        try {

            $request->validate([
                'roomImage1File' =>
                    'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

                'roomImage2File' =>
                    'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

                'roomImage3File' =>
                    'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

                'room_id' => 'required|integer',
            ]);

            $mainImageUrl = null;
            $secondImageUrl = null;
            $thirdImageUrl = null;

            if ($request->hasFile('roomImage1File')) {

                $image = $request->file('roomImage1File');

                $name =
                    time() . '_1.' .
                    $image->getClientOriginalExtension();

                $image->storeAs(
                    'public/uploads/roomImages',
                    $name
                );

                $mainImageUrl =
                    asset(
                        'storage/uploads/roomImages/' .
                        $name
                    );
            }

            if ($request->hasFile('roomImage2File')) {

                $image = $request->file('roomImage2File');

                $name =
                    time() . '_2.' .
                    $image->getClientOriginalExtension();

                $image->storeAs(
                    'public/uploads/roomImages',
                    $name
                );

                $secondImageUrl =
                    asset(
                        'storage/uploads/roomImages/' .
                        $name
                    );
            }

            if ($request->hasFile('roomImage3File')) {

                $image = $request->file('roomImage3File');

                $name =
                    time() . '_3.' .
                    $image->getClientOriginalExtension();

                $image->storeAs(
                    'public/uploads/roomImages',
                    $name
                );

                $thirdImageUrl =
                    asset(
                        'storage/uploads/roomImages/' .
                        $name
                    );
            }

            $roomImage = new dormimagesModel();

            $roomImage->fkdormID = $request->room_id;
            $roomImage->mainImage = $mainImageUrl;
            $roomImage->secondaryImage = $secondImageUrl;
            $roomImage->thirdImage = $thirdImageUrl;

            $roomImage->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Images uploaded successfully!',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Throwable $e) {

            Log::error('dormImages error', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Validate Main Image
    |--------------------------------------------------------------------------
    */
    public function editmainImage(Request $request)
    {
        try {

            if ($request->hasFile('roomImage1File')) {

                $request->validate([
                    'roomImage1File' =>
                        'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
            }

            return response()->json([
                'status' => 'success'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->errors(),
            ], 422);

        } catch (\Throwable $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Validate Secondary Image
    |--------------------------------------------------------------------------
    */
    public function editsecondaryImage(Request $request)
    {
        try {

            if ($request->hasFile('roomImage2File')) {

                $request->validate([
                    'roomImage2File' =>
                        'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
            }

            return response()->json([
                'status' => 'success'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->errors(),
            ], 422);

        } catch (\Throwable $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Update Dorm Images
    |--------------------------------------------------------------------------
    */
    public function imageUpdated(Request $request, $id)
    {
        try {

            $request->validate([
                'roomImage1File' =>
                    'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

                'roomImage2File' =>
                    'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

                'roomImage3File' =>
                    'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

                'dorm_id' => 'required|integer',
            ]);

            $roomImage = dormimagesModel::where(
                'imagesID',
                $id
            )
            ->where(
                'fkdormID',
                $request->dorm_id
            )
            ->first();

            if (!$roomImage) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Image record not found.'
                ], 404);
            }

            /*
            |--------------------------------------------------------------------------
            | Main Image
            |--------------------------------------------------------------------------
            */
            if ($request->hasFile('roomImage1File')) {

                $image = $request->file(
                    'roomImage1File'
                );

                $name =
                    time() . '_1.' .
                    $image->getClientOriginalExtension();

                $image->storeAs(
                    'public/uploads/roomImages',
                    $name
                );

                $roomImage->mainImage =
                    asset(
                        'storage/uploads/roomImages/' .
                        $name
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | Secondary Image
            |--------------------------------------------------------------------------
            */
            if ($request->hasFile('roomImage2File')) {

                $image = $request->file(
                    'roomImage2File'
                );

                $name =
                    time() . '_2.' .
                    $image->getClientOriginalExtension();

                $image->storeAs(
                    'public/uploads/roomImages',
                    $name
                );

                $roomImage->secondaryImage =
                    asset(
                        'storage/uploads/roomImages/' .
                        $name
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | Third Image
            |--------------------------------------------------------------------------
            */
            if ($request->hasFile('roomImage3File')) {

                $image = $request->file(
                    'roomImage3File'
                );

                $name =
                    time() . '_3.' .
                    $image->getClientOriginalExtension();

                $image->storeAs(
                    'public/uploads/roomImages',
                    $name
                );

                $roomImage->thirdImage =
                    asset(
                        'storage/uploads/roomImages/' .
                        $name
                    );
            }

            $roomImage->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Images updated successfully!',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Throwable $e) {

            Log::error('imageUpdated error', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'image_id' => $id,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}