import { ref } from 'vue'
import { useRouter } from 'vue-router'

export const useParkingAuth = (onPetugasLogin: () => void) => {
  const router = useRouter()

  const email = ref('')
  const password = ref('')
  const role = ref<'petugas' | 'super_admin'>('petugas')
  const showPassword = ref(false)
  const loading = ref(false)
  const error = ref('')

  const showForgotModal = ref(false)
  const resetEmail = ref('')
  const forgotLoading = ref(false)
  const forgotError = ref('')
  const forgotSuccess = ref(false)

  const isLoggedIn = ref(false)
  const activeRole = ref('')

  const openForgotPassword = () => {
    resetEmail.value = email.value
    forgotError.value = ''
    forgotSuccess.value = false
    showForgotModal.value = true
  }

  const closeForgotPassword = () => {
    showForgotModal.value = false
  }

  const handleResetPassword = () => {
    forgotError.value = ''

    if (!resetEmail.value) {
      forgotError.value = 'Email wajib diisi.'
      return
    }

    forgotLoading.value = true

    setTimeout(() => {
      forgotLoading.value = false
      forgotSuccess.value = true
    }, 500)
  }

  const handleLogin = () => {
    error.value = ''

    if (!email.value.trim()) {
      error.value = 'Email harus diisi.'
      return
    }

    if (!password.value.trim()) {
      error.value = 'Password harus diisi.'
      return
    }

    loading.value = true

    setTimeout(() => {
      loading.value = false

      if (role.value === 'super_admin') {
        isLoggedIn.value = false
        activeRole.value = ''
        router.push('/admin')
        return
      }

      isLoggedIn.value = true
      activeRole.value = 'petugas'
      onPetugasLogin()
    }, 400)
  }

  const handleLogout = () => {
    isLoggedIn.value = false
    activeRole.value = ''
    password.value = ''
    error.value = ''

    if (router.currentRoute.value.path !== '/') {
      router.push('/')
    }
  }

  return {
    email,
    password,
    role,
    showPassword,
    loading,
    error,
    showForgotModal,
    resetEmail,
    forgotLoading,
    forgotError,
    forgotSuccess,
    isLoggedIn,
    activeRole,
    openForgotPassword,
    closeForgotPassword,
    handleResetPassword,
    handleLogin,
    handleLogout,
  }
}
