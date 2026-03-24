<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\ItemType;
use App\Models\Unit;
use App\Http\Requests\ItemSearchRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Storage;

class ItemController extends Controller
{
    /** Cache key for menu items list. */
    public const MENU_ITEMS_CACHE_KEY = 'menu_items';

    /** Cache TTL: 1 hour. */
    public const MENU_ITEMS_CACHE_TTL = 3600;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $collection = Cache::remember(self::MENU_ITEMS_CACHE_KEY, self::MENU_ITEMS_CACHE_TTL, function () {
            return Item::with(['itemType', 'ingredient', 'unit'])->orderBy('id', 'desc')->get();
        });

        $page = $request->get('page', 1);
        $perPage = 15;
        $items = new LengthAwarePaginator(
            $collection->forPage($page, $perPage),
            $collection->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('items.index', ['metaTitle' => 'جميع الاصناف'], compact('items'));
    }

    /**
     * Clear menu items cache (call after item create/update/destroy).
     */
    protected function clearMenuItemsCache(): void
    {
        Cache::forget(self::MENU_ITEMS_CACHE_KEY);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $itemTypes = ItemType::all();
        $ingredients = Ingredient::all();
        $units = Unit::all();

        return view('items.create',['metaTitle' => 'صنف جديد'],compact('itemTypes','ingredients','units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'name' => 'required',
            'price' => 'required',
            'icon' => 'required|image|max:10000',
            'item_type_id' => 'required',
            'ingredient_id' => 'required'
         ]);



        if ($request->hasFile('icon')) {
            $file = $request->icon;
            $icon = uniqid().".".$file->getClientOriginalExtension();
            $file->storeAs('images\items',$icon,'public');
        }


        $item = new Item;

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'icon' => $icon,
            'item_type_id' => $request->item_type_id,
            'ingredient_id' => $request->ingredient_id
        ];

        if (Item::create($data)) {
            $this->clearMenuItemsCache();
            $request->session()->flash('success','تم حفظ الصنف بنجاح');
            return redirect()->route('item.index');
        }else {
            return redirect()->route('item.create');
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $itemTypes = ItemType::all();
        $ingredients = Ingredient::all();
        $units = Unit::all();

        return view('items.edit',['metaTitle' => 'تحديث صنف'],compact('itemTypes','ingredients','item','units'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $this->validate($request,[
            'name' => 'required',
            'price' => 'required',
            'icon' => 'image|max:10000',
            'item_type_id' => 'required',
            'ingredient_id' => 'required',
         ]);

        if ($request->hasFile('icon')) {
            $file = $request->icon;
            $icon = uniqid().".".$file->getClientOriginalExtension();
            $file->storeAs('images\items',$icon,'public');

            //Storage::disk('items')->delete($item->image);
        }else {
            $icon = $item->icon;
        }

        

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            
            'icon' => $icon,
            'item_type_id' => $request->item_type_id,
            'ingredient_id' => $request->ingredient_id,
            
        ];

        if ($item->update($data)) {
            $this->clearMenuItemsCache();
            $request->session()->flash('success','تم تحديث الصنف بنجاح');
            return redirect()->route('item.index');
        }else {
            return redirect()->route('item.edit',$item->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }

    function search(ItemSearchRequest $request)  {
       
        $result = Item::where('name','like',"%".$request->q."%")->
                        orWhereHas('itemType',function ($query) use ($request) {
                            $query->where('type','like',"%".$request->q."%");
                        })->paginate(20);
        return view('items.search',['metaTitle' => 'نتيجة البحث'])->with(['items'=> $result]);
    }
}
