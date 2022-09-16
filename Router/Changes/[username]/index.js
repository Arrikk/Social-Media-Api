import React, { useState, useContext, useEffect } from 'react'
import Head from 'next/head'
import {
  Layout,
  PersonalProfile,
  Widgets,
  Friends,
  Suggestions,
} from '../../components'
import { useRouter } from 'next/router'
import profileContext from '../../context/profile/profileContext'

const ProfileFriends = () => {
  const {currentProfile, profile, loading} = useContext(profileContext)
  const router = useRouter()
  const {username} = router.query

  
  useEffect(() => {
    currentProfile(username)
  }, [username])

  return (
    <>
      <Head>
        <title>Profile</title>
        <link rel="icon" href="/favicon.ico" />
      </Head>
      <Layout>
        <PersonalProfile />
        <Widgets>
          <Suggestions />
          <Friends />
        </Widgets>
      </Layout>
    </>
  )
}

export default ProfileFriends
