import React, { useState, useEffect } from 'react'
import Head from 'next/head'
import { Layout, PersonalProfile, Suggestions, Widgets } from '../../components'
import { useSelector } from 'react-redux'
import Friends from './../../components/shared/Friends';

const profile = () => {
  const { loading, user } = useSelector((state) => ({ ...state.auth }))
  const [token, setToken ] = useState(null)
  
  useEffect(() => {
    const token = JSON.parse(localStorage.getItem('profile'))
    setToken(token.token)
  }, [])
  
  return (
    <>
      <Head>
        <title>Profile</title>
        <link rel="icon" href="/favicon.ico" />
      </Head>
      <Layout>
        <PersonalProfile isMyProfile={true} />
        <Widgets>
          <Suggestions />
          <Friends myFriends={true} />
        </Widgets>
      </Layout>
    </>
  )
}

export default profile
