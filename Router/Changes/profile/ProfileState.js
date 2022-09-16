import ProfileContext from './profileContext'
import profileReducer from './profileReducer'
import { useReducer } from 'react'
import { LOAD_CURRENT_PROFILE, SET_ERROR, SET_LOADING, GET_FEED } from '../types'
import axios from 'axios'

const ProfileState = (props) => {
  const defaultState = {
    loading: true,
    profile: null,
    feeds: null,
    feedLoading: true
  }

  const [state, dispatch] = useReducer(profileReducer, defaultState)
  const resetLoading = () => {
    dispatch({
      type: SET_LOADING,
    })
  }
  const currentProfile = (username) => {
    resetLoading()
    axios.get('profile/'+username).then(res => {
      dispatch({
        type: LOAD_CURRENT_PROFILE,
        payload: res.data
      })
      // console.log(res.data)
    }).catch(err => {
      dispatch({
        type: SET_ERROR
      })
    })
  }

  const currentProfileFeed = () => {
    state.feedLoading = true
    axios.get(`my/feeds?agent=${state.profile?.userId}`)
    .then(res => {
      dispatch({
        type: GET_FEED,
        payload: res.data
      })
    }).catch(err => {
      dispatch({
        type: SET_ERROR
      })
    })
  }

  return (
    <ProfileContext.Provider
      value={{
        profile: state.profile,
        loading: state.loading,
        feedLoading: state.feedLoading,
        feeds: state.feeds,
        currentProfile,
        currentProfileFeed,
      }}
    >
      {props.children}
    </ProfileContext.Provider>
  )
}

export default ProfileState
