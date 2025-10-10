@extends('base.layout')

 @section('contenido')

  <section class="bg-gray-50 dark:bg-gray-900 py-3 sm:py-5">
         <div class="px-4 mx-auto max-w-screen-2xl lg:px-12">
             <div class="relative overflow-hidden bg-white shadow-md dark:bg-gray-800 sm:rounded-lg p-4">
                 <div class="mb-8">
                     <h3 class="text-xl font-semibold mb-4">Crear seccion nueva</h3>
                     <form class="space-y-4">
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                             <div>
                                 <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                                 <input type="text" name=nombre id=nombre
                                     class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                     required>
                             </div>
                             <div>
                             <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                            <input type="text" name=descripcion id=descripcion
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                required>
                        </div>
                             
                             <div class="mt-4">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                                <textarea name="estado" id=estado class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" rows="3" required></textarea>
                            </div>

                             <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">contenido</label>
                                <select name="contenido_id" id="contenido_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                    <option value="">Seleccione un contenido</option>
                                    @foreach($contenidos as $contenidos)
                                        <option value="{{ $contenidos->id }}">{{ $contenidos->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                         </div>
                         <button type="submit"
                             class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                             Crear seccion
                         </button>
                     </form>
                 </div>
             </div>
         </div>
     </section>
     @endsection