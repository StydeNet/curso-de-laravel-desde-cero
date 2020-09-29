<x-enlighten-info-panel>
    <x-slot name="title">Response</x-slot>
    <div class="p-4">
        <span class="p-1 bg-green-200 text-green-700">{{ $codeExample->response_status }}</span>
        <span class="text-gray-100">{{ $codeExample->response_type }}</span>
    </div>
    <x-enlighten-key-value :items="$codeExample->response_headers" title="Response Headers"></x-enlighten-key-value>
</x-enlighten-info-panel>