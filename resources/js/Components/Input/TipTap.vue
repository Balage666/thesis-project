<script setup>
import { useEditor, EditorContent } from "@tiptap/vue-3";
import StarterKit from "@tiptap/starter-kit";

const editor = useEditor({
    editorProps: {
        attributes: {
            class: "p-4 border border-secondary tip-tap-size overflow-y-auto",
        },
    },
    content: "<p>I’m running Tiptap with Vue.js. 🎉</p>",
    extensions: [StarterKit],
});
</script>

<template>
    <div
        v-if="editor"
        class="d-flex align-items-center column-gap-4 flex-wrap border border-bottom-0 border-secondary p-4"
    >
        <button
            @click="editor.chain().focus().toggleBold().run()"
            :disabled="!editor.can().chain().focus().toggleBold().run()"
            :class="{ 'bg-secondary': editor.isActive('bold') }"
            class="btn p-1"
        >
            bold
        </button>

        <button
            @click="editor.chain().focus().toggleItalic().run()"
            :disabled="!editor.can().chain().focus().toggleItalic().run()"
            :class="{ 'bg-secondary': editor.isActive('italic') }"
            class="btn p-1"
        >
            italic
        </button>
        <button
            @click="editor.chain().focus().toggleStrike().run()"
            :disabled="!editor.can().chain().focus().toggleStrike().run()"
            :class="{ 'bg-secondary': editor.isActive('strike') }"
            class="btn bg-white p-1"
        >
            strike
        </button>
        <button
            @click="editor.chain().focus().toggleCode().run()"
            :disabled="!editor.can().chain().focus().toggleCode().run()"
            :class="{ 'bg-secondary': editor.isActive('code') }"
            class="btn bg-white p-1"
        >
            code
        </button>
        <button
            @click="editor.chain().focus().unsetAllMarks().run()"
            class="btn bg-white p-1"
        >
            clear marks
        </button>
        <button
            @click="editor.chain().focus().clearNodes().run()"
            class="btn bg-white p-1"
        >
            clear nodes
        </button>
        <button
            @click="editor.chain().focus().setParagraph().run()"
            :class="{ 'bg-secondary': editor.isActive('paragraph') }"
            class="btn bg-white p-1"
        >
            paragraph
        </button>
        <button
            @click="editor.chain().focus().toggleHeading({ level: 1 }).run()"
            :class="{
                'bg-secondary': editor.isActive('heading', { level: 1 }),
            }"
            class="btn bg-white p-1"
        >
            h1
        </button>
        <button
            @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
            :class="{
                'bg-secondary': editor.isActive('heading', { level: 2 }),
            }"
            class="btn bg-white p-1"
        >
            h2
        </button>
        <button
            @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
            :class="{
                'bg-secondary': editor.isActive('heading', { level: 3 }),
            }"
            class="btn bg-white p-1"
        >
            h3
        </button>
        <button
            @click="editor.chain().focus().toggleHeading({ level: 4 }).run()"
            :class="{
                'bg-secondary': editor.isActive('heading', { level: 4 }),
            }"
            class="btn bg-white p-1"
        >
            h4
        </button>
        <button
            @click="editor.chain().focus().toggleHeading({ level: 5 }).run()"
            :class="{
                'bg-secondary': editor.isActive('heading', { level: 5 }),
            }"
            class="btn bg-white p-1"
        >
            h5
        </button>
        <button
            @click="editor.chain().focus().toggleHeading({ level: 6 }).run()"
            :class="{
                'bg-secondary': editor.isActive('heading', { level: 6 }),
            }"
            class="btn bg-white p-1"
        >
            h6
        </button>
        <button
            @click="editor.chain().focus().toggleBulletList().run()"
            :class="{ 'bg-secondary': editor.isActive('bulletList') }"
            class="btn bg-white p-1"
        >
            bullet list
        </button>
        <button
            @click="editor.chain().focus().toggleOrderedList().run()"
            :class="{ 'bg-secondary': editor.isActive('orderedList') }"
            class="btn bg-white p-1"
        >
            ordered list
        </button>
        <button
            @click="editor.chain().focus().toggleCodeBlock().run()"
            :class="{ 'bg-secondary': editor.isActive('codeBlock') }"
            class="btn bg-white p-1"
        >
            code block
        </button>
        <button
            @click="editor.chain().focus().toggleBlockquote().run()"
            :class="{ 'bg-secondary': editor.isActive('blockquote') }"
            class="btn bg-white p-1"
        >
            blockquote
        </button>
        <button
            @click="editor.chain().focus().setHorizontalRule().run()"
            class="btn bg-white p-1"
        >
            horizontal rule
        </button>
        <button
            @click="editor.chain().focus().setHardBreak().run()"
            class="btn bg-white p-1"
        >
            hard break
        </button>
        <button
            @click="editor.chain().focus().undo().run()"
            :disabled="!editor.can().chain().focus().undo().run()"
            class="btn bg-white p-1"
        >
            undo
        </button>
        <button
            @click="editor.chain().focus().redo().run()"
            :disabled="!editor.can().chain().focus().redo().run()"
            class="btn bg-white p-1"
        >
            redo
        </button>
    </div>
    <EditorContent :editor="editor" />
</template>

<style scoped></style>
