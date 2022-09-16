
import {LOAD_CURRENT_PROFILE, SET_ERROR, SET_LOADING, GET_FEED} from '../types'

const userReducer = (state, action) => {
    switch (action.type) {
        case LOAD_CURRENT_PROFILE:
            return {
                ...state,
                profile: action.payload,
                friends: action.payload?.friends,
                loading: false
            };
        case GET_FEED:
            return {
                ...state,
                feedLoading: false,
                feeds: action.payload
            };
        case SET_ERROR:
            return {
                ...state,
                loading: false
            }
        case SET_LOADING:
            return {
                ...state, loading: true
            }
        default:
            return state
    }
}

export default userReducer