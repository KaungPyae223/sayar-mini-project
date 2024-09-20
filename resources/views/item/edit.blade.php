@extends('vouchers.layout')


@section('breadcrumb')
    Item Edit
@endsection
@section('content')

        <section>
            <div class="max-w-4xl mx-auto p-4">
                <form action="{{ route('item.update',$item->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                     <!-- Product Photo -->
                <div class="mb-4">


                    <div class="flex items-center justify-center w-full">
                        <label for="dropzone-file"
                            class="flex flex-col items-center overflow-hidden justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">


                            <div id="imagePreview" style="display: none;" class="flex flex-col items-center justify-center h-full" style="display:none;">
                                <img id="previewImg" src="{{asset('storage/itemImage/'.$item->image)}}" class="h-full object-contain" alt="Image preview" style="display:none;">
                              </div>

                        </label>
                        <input id="dropzone-file" type="file" name="image" class="hidden" />

                    </div>

                </div>

                <!-- Product Title, Category, Price, and Stock -->
                <div class="flex space-x-4 mb-4">

                    <div class="flex-1">
                        <label for="product-title" class="block text-sm font-medium text-gray-700">Product Title</label>
                        <input type="text" value="{{old("title",$item->title)}}" id="product-title" name="title"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" />
                            @error("title")

                            <p class="text-sm text-bold text-red-700">{{$message}}</p>

                        @enderror
                        </div>
                    <div class="flex-1">
                        <label for="product-category" class="block text-sm font-medium text-gray-700">Category</label>
                        <select id="product-category" name="category_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            @foreach ($categories as $category)
                                <option {{$category->id == $item->category_id?"selected":""}} value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1">
                        <label for="product-price" class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" value="{{old("price",$item->price)}}" id="product-price" name="price"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" />
                            @error("price")

                            <p class="text-sm text-bold text-red-700">{{$message}}</p>

                        @enderror
                        </div>
                    <div class="flex-1">
                        <label for="product-stock" class="block text-sm font-medium text-gray-700">Stock</label>
                        <input type="number" value="{{old("stock",$item->stock)}}" id="product-stock" name="stock"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" />
                            @error("stock")

                            <p class="text-sm text-bold text-red-700">{{$message}}</p>

                        @enderror
                        </div>
                </div>

                <!-- Product Description -->
                <div class="mb-4">
                    <label for="product-description" class="block text-sm font-medium text-gray-700">Product
                        Description</label>
                    <textarea id="product-description" name="description" rows="4"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{old("description",$item->description)}}</textarea>
                        @error("description")

                        <p class="text-sm text-bold text-red-700">{{$message}}</p>

                    @enderror
                    </div>

                <!-- Save and Cancel Buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('item.index') }}"
                        class="text-gray-700 bg-white border border-gray-300 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-md text-sm px-4 py-2 hover:bg-gray-100 hover:text-blue-700">Cancel</a>
                    <button type="submit"
                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-md text-sm px-4 py-2">Edit</button>
                </div>
                </form>
            </div>

        </section>

        <script>
            const imageUpload = document.getElementById('dropzone-file');
            const previewImg = document.getElementById('previewImg');
            const uploadLabel = document.getElementById('uploadLabel');
            const imagePreview = document.getElementById('imagePreview');
            // Listen for the file input change event
            imageUpload.addEventListener('change', function() {
              const file = this.files[0];  // Get the uploaded file

              if (file) {
                const reader = new FileReader();

                // Load the image file as a data URL
                reader.onload = function(e) {
                  previewImg.src = e.target.result; // Set the image src to the result of the FileReader
                  previewImg.style.display = 'block'; // Make the image visible
                  uploadLabel.style.display = 'none';
                    imagePreview.style.display = 'block';
                };

                reader.readAsDataURL(file);  // Read the file as a Data URL
              }
            });
          </script>

@endsection
