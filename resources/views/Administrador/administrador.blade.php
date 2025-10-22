@extends('base.layout')

 @section('contenido')
     <section class="bg-gray-50 dark:bg-gray-900 py-3 sm:py-5">
         <div class="px-4 mx-auto max-w-screen-2xl lg:px-12">
             <div class="relative overflow-hidden bg-white shadow-md dark:bg-gray-800 sm:rounded-lg p-4">
                 <div class="mb-8">
                     <h3 class="text-xl font-semibold mb-4">Crear Nuevo Administrador</h3>
                     <form class="space-y-4">
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                             <div>
                                 <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                                 <input type="text" name=nombre id=nombre 
                                     class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                     required>
                             </div>
                             <div>
                             <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Apellido</label>
                            <input type="text" name=apellido id=apellido
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                required>
                        </div>
                             <div>
                                 <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">email
                                    </label>
                                 <input type="email" name=email id=email
                                     class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                     required>
                             </div>
                             <div>
                                 <label
                                     class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">password</label>
                                 <input type="password" name=password id=password 
                                     class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                     required>
                             </div>
                         </div>
                         <button type="submit"
                             class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                             Crear Administrador
                         </button>
                     </form>
                 </div>
             </div>
         </div>
     </section>
 @endsection


 