<template>
	<div>
		<button
			ref="formToggle"
			class="feedback-btn btn btn-primary"
			@click="toggleForm"
		>
			<span>
				{{ buttonLabel }}
			</span>
		</button>
		<div
			v-if="isActive"
			id="feedbackform"
			ref="dialog"
			class="feedback-form"
			role="dialog"
			aria-modal="false"
			aria-labelledby="feedbackform-title"
			tabindex="-1"
		>
			<form
				class="form"
				@submit.prevent="onSubmit"
			>
				<h2
					id="feedbackform-title"
					class="mb-2 h6 text-sm"
				>
					{{ formTitle }}
				</h2>
				<p
					v-if="success"
					class="text-success text-center whitespace-pre-wrap"
				>
					{{ successMessage }}
				</p>
				<p
					v-if="errors"
					class="text-danger text-center"
				>
					{{ errors }}
				</p>
				<div class="form-control">
					<label
						class="form-label"
						for="feedback-name"
					>
						Name
						<span
							class="required"
							aria-hidden="true"
						>
							*
						</span>
					</label>
					<input
						id="feedback-name"
						ref="nameInputField"
						v-model="nameField"
						type="text"
						required
					>
				</div>
				<div class="form-control">
					<label
						class="form-label"
						for="feedback-email"
					>Email</label>
					<input
						id="feedback-email"
						v-model="emailField"
						type="email"
					>
				</div>
				<div class="form-control">
					<label
						class="form-label"
						for="feedback-body"
					>
						Comment
						<span
							class="required"
							aria-hidden="true"
						>
							*
						</span>
					</label>
					<textarea
						id="feedback-body"
						v-model="comment"
						class="resize-none"
						type="text"
						required
					/>
				</div>
				<button
					:disabled="!isValid"
					class="btn btn-primary"
					type="submit"
				>
					<svg
						v-if="isLoading"
						class="loader"
						viewBox="8 8 16 16"
						fill="none"
						width="32"
						height="32"
					>
						<circle
							cx="16"
							cy="16"
							r="7"
							fill="none"
							stroke="#000"
							opacity=".1"
							stroke-width="2"
						/>
						<circle
							class="loader-path"
							cx="16"
							cy="16"
							r="7"
							fill="none"
							stroke="#70c542"
							stroke-width="2"
						/>
					</svg>
					<div v-else>
						{{ submitButtonLabel }}
					</div>
				</button>
			</form>
		</div>
	</div>
</template>

<script>
import axios from 'axios';

export default {
	props: {
		name: {
			type: String,
			default: '',
		},
		email: {
			type: String,
			default: '',
		},
		buttonLabel: {
			type: String,
			default: '?',
		},
		formTitle: {
			type: String,
			default: '',
		},
		successMessage: {
			type: String,
			default: 'Your feedback\nhas been submitted!',
		},
		submitButtonLabel: {
			type: String,
			default: 'Submit',
		},
		keepFieldsOnSubmit: {
			type: Boolean,
			default: false,
		},
	},
	data() {
		return {
			emailField: '',
			nameField: '',
			comment: null,
			isActive: false,
			isLoading: false,
			errors: null,
			success: false,
		};
	},

	computed: {
		isValid() {
			if (this.isLoading) {
				return false;
			}

			if (!this.nameField) {
				return false;
			}

			if (!this.comment) {
				return false;
			}

			return true;
		},
	},

	watch: {
		isActive(value) {
			if (value) {
				return;
			}

			// Reset the state of the form.
			this.success = false;
			this.errors = null;
		},
	},

	mounted() {
		this.comment = null;
	},

	methods: {
		toggleForm() {
			this.isActive ? this.hideForm() : this.showForm();
		},

		showForm() {
			this.isActive = true;

			if (this.email) {
				this.emailField = this.email;
			}
			if (this.name) {
				this.nameField = this.name;
			}

			this.$nextTick(() => {
				document.addEventListener('keydown', this.closeOnEscape);
				document.addEventListener('click', this.closeOnClickOutside);
				document.addEventListener('focusin', this.closeOnFocusOutside);

				this.$refs.nameInputField.focus();
			});
		},

		hideForm() {
			this.isActive = false;

			this.$nextTick(() => {
				document.removeEventListener('keydown', this.closeOnEscape);
				document.removeEventListener('click', this.closeOnClickOutside);
				document.removeEventListener('focusin', this.closeOnFocusOutside);
			});
		},

		closeOnEscape(e) {
			if (e.keyCode === 27 && this.isActive) {
				this.hideForm();

				this.$nextTick(() => {
					this.$refs.toggleForm.focus();
				});
			}
		},

		closeOnClickOutside(e) {
			if (!this.$refs.dialog) {
				return;
			}

			if (e.target === this.$refs.dialog ||
				this.$refs.dialog.contains(e.target) ||
				e.target === this.$refs.formToggle
			) {
				return;
			}

			this.hideForm();
		},

		closeOnFocusOutside() {
			this.closeOnClickOutside({ target: document.activeElement });
		},

		async onSubmit() {
			try {
				this.errors = null;
				this.success = false;
				this.isLoading = true,

				await axios.post('/simple-feedback', {
					name: this.nameField,
					email: this.emailField,
					comment: this.comment,
				});

				this.isLoading = false;
				this.success = true;

				this.reset();
			} catch (error) {
				this.isLoading = false;
				this.errors = error.message;
			}
		},

		reset() {
			if (this.keepFieldsOnSubmit) return;

			this.nameField = null;
			this.emailField = null;
			this.comment = null;
		},
	},
};
</script>

<style scoped lang="scss">
.feedback-form {
	position: fixed;
	z-index: 99;
	bottom: 4.5em;
	right: 1em;
	max-width: 24em;

	.form {
		max-width: 16em;
		padding: 2em;
		margin-bottom: 1em;
	}
	.form-control {
		width: 100%;
		margin-bottom: 1em;
		display: block;
	}
}
.feedback-btn {
	position: fixed;
	z-index: 100;
	bottom: 1em;
	right: 1em;
	font-size: 1em;
	padding: .5em 1em;
	text-align: center;

	span {
		pointer-events: none;
	}
}
</style>
