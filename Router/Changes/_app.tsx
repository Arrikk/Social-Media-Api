import '../styles/globals.css'
import 'react-toastify/dist/ReactToastify.css'
import type { AppProps } from 'next/app'
import { ThemeProvider } from 'next-themes'
import { Provider } from 'react-redux'
import store from '../redux/store'
import { ToastContainer } from 'react-toastify'
import { axiosDefaults } from './../hooks/AxiosDefaults'
import UserState from './../context/user/UserState'
import ProfileState from './../context/profile/ProfileState'
// import UserState from '../context/u'

function MyApp({ Component, pageProps }: AppProps) {
  axiosDefaults()
  return (
    <Provider store={store}>
      <UserState>
        <ProfileState>
          <ThemeProvider enableSystem={true} attribute="class">
            <Component {...pageProps} />
            <ToastContainer />
          </ThemeProvider>
        </ProfileState>
      </UserState>
    </Provider>
  )
}

export default MyApp
