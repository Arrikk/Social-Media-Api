import { ProfileHeader, ProfileMedia } from './index'

const PersonalProfile = ({isMyProfile}) => {
  return (
    <div className="col-span-10 border-x sm:col-span-9 md:col-span-8 lg:col-span-5 overflow-y-scroll no-scrollbar">
      <ProfileHeader isMyProfile={isMyProfile} />
      <ProfileMedia isMyProfile={isMyProfile} />
    </div>
  )
}

export default PersonalProfile
