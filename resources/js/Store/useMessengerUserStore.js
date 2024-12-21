import axios from "axios";
import { defineStore } from "pinia";
import { useMessengerLeftFriendWithLatestMessageStore } from "./useMessengerLeftFriendWithLatestMessageStore";

export const useMessengerUserStore = defineStore('messenger',{
    // State
    state: () => ({
        messages: [],
        friendData: null,
        page: 1,
        next: null,
        latestMessage: null
    }),
    
    // Getter
    getters: {
        allMessage() {
            return this.messages
        }
    },

    // Action
    actions: {
        // Loading & Setting initial data
        async loadMessages(friendData, page = 1) {
            this.friendData = friendData
            const response = await axios.get(route('message.load', [friendData.user_name]), {
                params: {
                    page: page
                }
            })
            this.next = (response.data.links.next) ? response.data.links.next : null
            this.page = response.data.meta.current_page
            this.messages = [...this.messages, ...response.data.data]
            
        },

        // Loading previous data
        async loadPreviousMessages() {
            this.loadMessages( this.friendData ,this.page + 1)
        },

        // Resetting state for new friend instance
        resetMessages() {
            this.messages = []
        },

        // Storing new message
        async storeMessage(payload) {

            const response = await axios.post(route('message.store', this.friendData.user_name), payload)
            this.appendNewMessageToCurrentState(response.data) // For message area
            
            // Updating Auth User End message state on sidebar
            const friendsWithLatestMessageStore = useMessengerLeftFriendWithLatestMessageStore()
            friendsWithLatestMessageStore.updateTheFriendWithLatestMessageOnAuthUserEnd(response.data)
        },

        // Appending new message to current message state (auth user end)
        appendNewMessageToCurrentState(newlyCreatedMessage) {
            if (this.messages.length == 25) {
                this.messages.pop()
            }
            this.messages = [newlyCreatedMessage, ...this.messages]
            this.latestMessage = newlyCreatedMessage

            
        },

    }// End Action
})