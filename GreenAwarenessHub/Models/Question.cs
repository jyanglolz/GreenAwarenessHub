using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
namespace GreenAwarenessHub.Models
{
    public class Question
    {
        [Key]
        public int QuestionID { get; set; }

        [ForeignKey("Quiz")]
        public int QuizID { get; set; }
        public Quiz Quiz { get; set; }

        
        public string ? QuestionText { get; set; }

       
        public string ? QuestionType { get; set; } // You can replace this with an enum if needed
    }
}
