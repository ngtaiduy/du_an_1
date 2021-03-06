<div class="p-6">

    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-5">
        <x-jet-input type="text" class="block mr-10" placeholder="Tìm kiếm" wire:model="search"/>
        <x-jet-button wire:click.prevent="createShowModal">
            {{ __('Thêm mới') }}
        </x-jet-button>
    </div>
    @if(Session::has('message'))
        <div class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold
        text-xs text-white uppercase tracking-widest">
            {{ Session::get('message') }}
        </div>
    @endif
    {{--    The data table--}}

    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tên Sản Phẩm
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Đường dẫn
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Giá bán
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Giảm giá
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Hình ảnh
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Hình ảnh phu
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Danh mục
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                View
                            </th>
                            <th class="relative px-6 py-3">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse( $products as $pro)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $pro->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $pro->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $pro->slug }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ number_format($pro->regular_price, 0, '.', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($pro->sale_price){{ number_format($pro->sale_price, 0, '.', '.') }}@endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <img src=" {{ asset('storage/'.$pro->feature_img) }}" width="100px" alt="">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @foreach($pro->product_image as $photo)
                                        <img src=" {{ asset('storage/'.$photo->image_path) }}" width="100px" alt="">
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $pro->category->name}}
{{--                                    @dd($pro->product)--}}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $pro->count_view }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="#" wire:click="updateShowModal({{$pro->id}})"
                                       class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <a href="#" wire:click="deleteShowModal({{ $pro->id }})"
                                       class="ml-4 text-red-600 hover:text-red-900">Delete</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center" colspan="10">
                                    No data
                                </td>
                            </tr>
                        @endforelse
                        <!-- More items... -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br>
    {{ $products->links() }}
    {{-- Modal Form --}}
    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{ __('Thêm Sản Phẩm') }} {{ $modelId }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-jet-label for="title" value="{{ __('Tên sản phẩm') }}"/>
                <x-jet-input id="name" class="block mt-1 w-full" type="text" wire:model.debounce.500ms="name"
                             wire:keyup="generatesSlug" required autocomplete="new-password"/>
                @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="slug" value="{{ __('Đường dẫn') }}"/>
                <div class="mt-1 flex rounded-md shadow-sm">
                  <span
                      class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                    http://luma.test/
                  </span>
                    <input wire:model="slug" type="text"
                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300"
                           placeholder="url-slug">
                </div>
                @error('slug') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="title" value="{{ __('Giá sản phẩm') }}"/>
                <x-jet-input id="regular_price" class="block mt-1 w-full" type="text"
                             wire:model.debounce.500ms="regular_price"
                             required/>
                @error('regular_price') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="title" value="{{ __('Giá khuyến mại') }}"/>
                <x-jet-input id="sale_price" class="block mt-1 w-full" type="text"
                             wire:model.debounce.500ms="sale_price"
                             required/>
                @error('sale_price') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <input type="file" class="hidden"
                       wire:model="feature_img"
                       x-ref="photo"/>
                <x-jet-label for="photo" value="{{ __('Photo') }}"/>
                @if ($image && $image == $feature_img)
                    <img src="{{ asset('storage/' . $feature_img) }}" class="rounded-2 h-20 w-20 object-cover">
                @elseif($image != $feature_img)
                    <img src="{{ $feature_img->temporaryUrl() }}" class="rounded-2 h-20 w-20 object-cover">
                @endif
                <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-jet-secondary-button>
                @error('feature_img') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <input type="file" class="hidden"
                       wire:model="photos"
                       x-ref="photos" multiple/>
                <x-jet-label for="photos" value="{{ __('Photo') }}"/>
                @if ($image_photo && $image_photo == $photos)
                    <div class="flex">
                        @foreach($photos as $photo)
                            <img src="{{ asset('storage/' . $photo->image_path) }}"
                                 class="rounded-2 h-20 w-20 object-cover">
                        @endforeach
                    </div>
                @elseif($image_photo != $photos)
                    <div class="flex">
                        @foreach($photos as $photo)
                            <img src="{{ $photo->temporaryUrl() }}" class="rounded-2 h-20 w-20 object-cover">
                        @endforeach
                    </div>
                @endif
                <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click="$refs.photos.click()">
                    {{ __('Select A New Photo') }}
                </x-jet-secondary-button>
{{--                @error('photos') <span class="text-red-500">{{ $message }}</span> @enderror--}}
            </div>

            <div class="mt-4">
                <x-jet-label for="title" value="{{ __('Danh mục') }}"/>
                <select wire:model="category_id"
                        class="form-select block w-full border-gray-300 focus:border-indigo-300  focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option>Chọn danh mục</option>
                    @if($categories)
                        @foreach($categories as $cate)
                            <option value="{{ $cate->id }}"> {{ $cate->name }}</option>
                        @endforeach
                    @endif
                </select>
                @error('category_id') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="content" value="{{ __('Miêu tả ngắn') }}"/>
                <div class="rounded-md shadow-sm">
                    <div class="mt-1 bg-white">
                        <div class="body-content" wire:ignore>
                            <textarea
                                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                wire:model="short_description"></textarea>
                        </div>
                    </div>
                    @error('short_description') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="mt-4">
                <x-jet-label for="" value="{{ __('Miêu tả chi tiết') }}"/>
                <div class="rounded-md shadow-sm">
                    <div class="mt-1 bg-white">
                        <div class="body-content" wire:ignore>
                           <textarea
                               class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                               wire:model="detail_description"></textarea>
                        </div>
                    </div>
                    @error('detail_description') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
            @if($modelId)
                <x-jet-button class="ml-2"
                              wire:click="update()"
                              wire:loading.attr="disabled">
                    {{ __('Sửa') }}
                </x-jet-button>
            @else
                <x-jet-button class="ml-2"
                              wire:click="create()"
                              wire:loading.attr="disabled">
                    {{ __('Thêm') }}
                </x-jet-button>
            @endif

        </x-slot>
    </x-jet-dialog-modal>

    {{--    Delete Modal--}}
    <x-jet-confirmation-modal wire:model="modalConfirmDeleteVisible">
        <x-slot name="title">
            {{ __('Xóa danh mục ❓') }} {{ $modelId }}
        </x-slot>

        <x-slot name="content">
            {{ __('Bạn có chắc chắn muốn xóa không?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalConfirmDeleteVisible')" wire:loading.attr="disabled">
                {{ __('Hủy') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Xóa') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

</div>
