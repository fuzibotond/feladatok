<?php

namespace App\Http\Controllers;

use App\Models\Auto;
use App\Models\Auto_eletkor;
use Illuminate\Http\Request;
use Resources\Category\create;
use Resources\Category\index;
use App\Models\Category;
use App\Http\Controlleres\AutoEletkorController;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::get();
        $autos = Auto::get();
        $auto_eletkors = Auto_eletkor::get();
        return view('category.index',['autos'=>$autos, 'auto_eletkors'=>$auto_eletkors,'categories'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $autos = Auto::get();
        $auto_eletkors = Auto_eletkor::get();
        // print_r($auto_eletkors);
        // die;
      
            return view('category.create', ['autos'=>$autos, 'auto_eletkors'=>$auto_eletkors]);
        
        
    }
    public function delete($id)
    {
    //  
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request,[
            'tulajdonos' => 'required|max:50',
            'auto'=> 'required',
            'garancialis' => 'bail',
            'eletkor' => 'required',
            'szerviz_kezdete' => 'required',
            'szerviz_vege' => 'bail'
        ]);

        $category = new Category([
            'tulajdonos' => $request->get('tulajdonos'),
            'auto' => $request->get('auto'),
            'garancialis' => $request->get('garancialis') ==='on' ? 1:0,
            'eletkor' => $request->get('eletkor')==='eletkor'?1:0,
            'szerviz_kezdete' => $request->get('szerviz_kezdet'),
            'szerviz_vege' => $request->get('szerviz_vege')
        ]);
        $category->save();
        return redirect()->route('categories.create')->with('success', 'Data Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $data = Category::get();
        $autos = Auto::get();
        $auto_eletkors = Auto_eletkor::get();
        return view('category.index',['autos'=>$autos, 'auto_eletkors'=>$auto_eletkors,'categories'=>$data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
         
        //
         
    }
    
    function editData($id){

        $data = Category::find($id);
        $data['szerviz_vege'] = date("Y-m-d\TH:i:s",time());
        return  view('category.index',['autos'=>$autos, 'auto_eletkors'=>$auto_eletkors,'categories'=>$data]);

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
    // public function login(Request $request){
    //     $user = User::where('emil', $req->input('email'))->get();
    //     if( Crypt:: decrypt($user[0]->password)==$request->input('password')){
    //         $request->session()->put('user', $request->input('name'));
    //         return redirect('/');
    //     }
    // }
//     public function radio(){
//         $auto_eletkors = AutoEletkor::get();
//         return view('category.radio')->with( 'auto_eletkors', $auto_eletkors );
//     }
}
