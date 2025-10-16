  @extends('base.layout')

 @section('contenido')

  <section class="bg-gray-50 dark:bg-gray-900 py-3 sm:py-5">
        <div class="px-4 mx-auto max-w-screen-2xl lg:px-12">
            <div class="relative overflow-hidden bg-white shadow-md dark:bg-gray-800 sm:rounded-lg p-4">
             <a href="{{ url('/contenidos/'.$contenido->id.'/mostrar') }}" class="btn btn-info">Ver</a>
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Borrar</button>
</form>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Titulo:{{ $contenido->titulo }}</label>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripcion:{{ $contenido->descripcion }}</label>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                <div>
                                <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Archivo: {{ optional($contenido->seccion)->nombre ?? 'no hay seccion' }}
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-center mt-6">
                            <button type="submit" id="enviar" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-8 py-3 text-center">
                                Borrar contenido
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    @endsection