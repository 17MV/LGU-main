<!-- Hidden overlay for displaying person details -->
<div id="person-details-overlay" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <!-- Person's name centered -->
        <h2 class="text-xl font-semibold mb-4 text-start" id="person-name"></h2>
        
        <!-- Person's details content -->
        <div id="person-details">
            <!-- Person details will be populated here -->
        </div>
        
        <!-- Centered Close button only -->
        <div class="flex justify-center mt-4">
            <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700" onclick="closeOverlay()">Close</button>
        </div>
    </div>
</div>

<!-- Styling for hidden class -->
<style>
.hidden {
    display: none;
}
</style>
