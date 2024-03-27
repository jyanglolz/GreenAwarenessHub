using System.ComponentModel.DataAnnotations;

namespace GreenAwarenessHub.Models
{
    public class Quiz
    {
        [Key]
        public int QuizID { get; set; }

        
        public string ? Title { get; set; }

        public string ? Description { get; set; }

       
        
    }
}
