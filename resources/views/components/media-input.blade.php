<div class="flex items-center" x-data="mediaPreview()">
    <div class="rounded-md bg-gray-200 mr-2">
        <img src="" class="w-24 h-20 rounded-md object-cover" id="preview">
    </div>
    <div>
        <div class="bg-indigo-600 rounded-md px-4 py-2">
            <a @click="document.getElementById('media').click()" class="relative cursor-pointer text-white">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline-flex flex-shrink-0 w-6 h-6 mr-1" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                        <path d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
                        <circle cx="12" cy="13" r="3" />						
                    </svg>
                    Choisir l'Image 
                </div>
                <input @change="showPreview(event)" type="file" name="media" id="media" class="absolute inset-0 -z-10 opacity-0" >
            </a>
        </div>
        <div class="w-full text-gray-500 text-xs mt-2">Cliquer pour ajouter l'image</div>
    </div>
    <script>
        function mediaPreview() {
            return {
                showPreview: (event) => {
                    if (event.target.files.length > 0) {
                        var src = URL.createObjectURL(event.target.files[0]);
                        document.getElementById('preview').src = src;
                    }
                }
            }
        }
    </script>
</div>