<template>
    <div>
        <h1>Notes</h1>
        <form @submit.prevent="saveNote">
            <input v-model="note.title" placeholder="Title" required />
            <input v-model="note.author" placeholder="Author" required />
            <input v-model="note.date_time" type="datetime-local" required />
            <textarea
                v-model="note.body"
                placeholder="Body"
                required
            ></textarea>
            <select v-model="note.classification">
                <option value="personal">Personal</option>
                <option value="work">Work</option>
                <option value="school">School</option>
            </select>
            <button type="submit">Save Note</button>
        </form>

        <ul>
            <li v-for="note in notes" :key="note.id">
                <h2>{{ note.title }}</h2>
                <p>{{ note.body }}</p>
                <small>By {{ note.author }} on {{ note.date_time }}</small>
                <button @click="editNote(note)">Edit</button>
                <button @click="deleteNote(note.id)">Delete</button>
            </li>
        </ul>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            notes: [],
            note: {
                title: "",
                author: "",
                date_time: "",
                body: "",
                classification: "personal",
            },
        };
    },
    methods: {
        fetchNotes() {
            axios.get("/api/notes").then((response) => {
                this.notes = response.data;
            });
        },
        saveNote() {
            if (this.note.id) {
                axios
                    .put(`/api/notes/${this.note.id}`, this.note)
                    .then(this.fetchNotes);
            } else {
                axios.post("/api/notes", this.note).then(this.fetchNotes);
            }
            this.resetNote();
        },
        editNote(note) {
            this.note = { ...note };
        },
        deleteNote(id) {
            axios.delete(`/api/notes/${id}`).then(this.fetchNotes);
        },
        resetNote() {
            this.note = {
                title: "",
                author: "",
                date_time: "",
                body: "",
                classification: "personal",
            };
        },
    },
    mounted() {
        this.fetchNotes();
    },
};
</script>
