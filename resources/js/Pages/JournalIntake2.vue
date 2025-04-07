<script setup>
import { ref, onMounted } from "vue";
import { useForm } from "@inertiajs/vue3";
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';

const form = useForm({
    title: "",
    subtitle: "",
    text: "",
    cover_image: "",
});

// Create a ref for the QuillEditor component
const quillEditorRef = ref(null);

// Handle content changes from the editor
const onEditorContentUpdated = (content) => {
    // Update the form with HTML content
    if (content) {
        // If the content is just the default empty editor state, use empty string
        const htmlContent = typeof content === 'object' ? content.html : content;
        form.text = (htmlContent === '<p><br></p>' || htmlContent === '<p></p>') ? '' : htmlContent;
        console.log('Editor content updated:', form.text);
    }
};

const submit = () => {
    // Final check to ensure text isn't null or empty placeholder
    if (!form.text || form.text === '<p><br></p>' || form.text === '<p></p>') {
        form.text = ''; // Set to empty string instead of null
    }

    console.log('Submitting form with text:', form.text);

    form.post(route("journal.store"), {
        onSuccess: () => {
            alert("Journal Entry created successfully!");
            form.reset();

            // Reset the editor content after form submission
            if (quillEditorRef.value) {
                quillEditorRef.value.setContents('');
            }
        },
        onError: (errors) => {
            console.error('Form submission errors:', errors);
        }
    });
};
</script>

<template>
    <div class="max-w-2xl mx-auto bg-white p-6 shadow-lg rounded-lg mt-10">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Create New Journal Entry</h2>

        <form @submit.prevent="submit" class="space-y-4">
            <!-- Title Field -->
            <div>
                <label for="title" class="block text-gray-700 font-medium">Title</label>
                <input
                    v-model="form.title"
                    type="text"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2"
                    required
                />
                <p v-if="form.errors.title" class="text-red-500 text-sm mt-1">{{ form.errors.title }}</p>
            </div>

            <div>
                <label for="subtitle" class="block text-gray-700 font-medium">Subtitle</label>
                <input
                    v-model="form.subtitle"
                    type="text"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2"
                    required
                />
                <p v-if="form.errors.subtitle" class="text-red-500 text-sm mt-1">{{ form.errors.subtitle }}</p>
            </div>

            <!-- Journal Entry Field -->
            <div class="form-group">
                <label for="text" class="block text-gray-700 font-medium">Journal Entry</label>
                <QuillEditor
                    ref="quillEditorRef"
                    v-model:content="form.text"
                    @update:content="onEditorContentUpdated"
                    theme="snow"
                    :toolbar="[
                        [{ header: [1, 2, 3, 4, 5, 6, false] }],
                        [{ font: [] }],
                        [{ size: ['small', false, 'large', 'huge'] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ color: [] }, { background: [] }],
                        [{ script: 'sub' }, { script: 'super' }],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        [{ indent: '-1' }, { indent: '+1' }],
                        [{ align: [] }],
                        ['blockquote', 'code-block'],
                        ['link', 'image', 'video'],
                        ['clean']
                    ]"
                    class="h-64"
                />
                <p v-if="form.errors.text" class="text-red-500 text-sm mt-1">{{ form.errors.text }}</p>
            </div>

            <div>
                <label for="cover" class="block text-gray-700 font-medium">Cover Image</label>
                <input
                    v-model="form.cover_image"
                    type="text"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2"
                    required
                />
                <p v-if="form.errors.cover_image" class="text-red-500 text-sm mt-1">{{ form.errors.cover_image }}</p>
            </div>

            <!-- Submit Button -->
            <div>
                <button
                    type="submit"
                    class="w-full bg-indigo-600 text-white font-semibold py-2 px-4 rounded-md hover:bg-indigo-700 transition duration-200"
                    :disabled="form.processing"
                >
                    Save Journal Entry
                </button>
            </div>
        </form>
    </div>
</template>

<style scoped>
.ql-container {
    height: 200px;
}
</style>
