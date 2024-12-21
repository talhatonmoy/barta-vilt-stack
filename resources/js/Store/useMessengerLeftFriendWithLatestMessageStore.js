import { defineStore } from "pinia";

// const authUser = $page.props.auth.user

export const useMessengerLeftFriendWithLatestMessageStore = defineStore('friendsWithLatestMessage', {
    state: () => ({
        friends: [],
        latestMessageOfActiveFriend: null
    }),

    actions: {
        loadInitialData(friendsWithLatestMessage) {
            this.friends = friendsWithLatestMessage,
            this.latestMessageOfActiveFriend = null
        },

        reset() {
            this.friends = []
        },

        // Receiver End
        updateTheFriendWithLatestOnMessageReceiverEnd(newMessage) {
            let friend = this.friends.find((friend) => friend.id === newMessage.sender_id  )
            if (friend) {
                friend.latest_message = newMessage
            }
            this.latestMessageOfFriend = newMessage
        },

        // Auth user end
        updateTheFriendWithLatestMessageOnAuthUserEnd(newMessage) {
            let friend = this.friends.find((friend) => friend.id === newMessage.receiver_id)
            if (friend) {
                friend.latest_message = newMessage
            }
        }
    }
})